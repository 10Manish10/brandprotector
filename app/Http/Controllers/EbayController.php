<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Client;
use App\Models\Datasets;
use App\Models\TKO_Ecommerce;
use Gate;
use DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class EbayController extends Controller
{
    private $channelName;
    private $ScrapperApiToken;
    private $ScrapperApiEndpoint;
    private $actor;
    private $StoreDataSetLimit;

    public function __construct() {
        // $this->middleware('auth');
        $this->channelName = "ebay";
        $this->actor = "dtrungtin~ebay-items-scraper";
        $this->ScrapperApiToken = env("ScrapperApiToken", "");
        $this->ScrapperApiEndpoint = env("ScrapperApiEndpoint", "");
        $this->StoreDataSetLimit = env("StoreDataSetLimit", 10);
        if ($this->ScrapperApiToken == "" || $this->ScrapperApiEndpoint == "") {
            abort(500, 'Please setup environment variables');
        }
    }

    public function pre($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public function authClient($channelId, $clientId, $returnClient = true) {
        $channel = Channel::where('id', $channelId)->first();
        if (!$channel) {
            abort(400, 'Invalid Channel');
        }
        $client = Client::where('id', $clientId)->first();
        if (!$client) {
            abort(400, 'Invalid Client');
        }
        $client->variables = unserialize($client->variables);
        $client->channels = unserialize($client->channels);
        $clientChannelIds = array_values($client->channels);
        if (!in_array($channelId, $clientChannelIds)) {
            abort(403, 'Unauthorized Access');
        }
        $channelName = array_flip($client->channels)[$channelId];
        $client->channelData = $client->variables[$channelName];
        $sessionKey = "channel_".$channelId."__client_".$clientId;
        Session::put($sessionKey, "AUTH_OK");

        $whitelistValue = "";
        if (isset($client->channelData['Whitelist']) && !empty($client->channelData['Whitelist'])) {
            $whitelistValue = $client->channelData['Whitelist']['data'];
        }
        if (isset($client->channelData['whitelist']) && !empty($client->channelData['whitelist'])) {
            $whitelistValue = $client->channelData['whitelist']['data'];
        }
        if ($whitelistValue != "") {
            $whitelistKey = "channel_".$channelId."__client_".$clientId."__whitelistKey";
            Session::put($whitelistKey, $whitelistValue);
        }
        if ($returnClient) {
            return $client;
        }
    }

    public function test($channelId, $clientId) {
        $client = $this->authClient($channelId, $clientId);
        $this->pre($client->channelData);
        return true;
    }

    /**
     * This function will create a Dataset on apify, based on the actor and keyword payload
     * The dataset will take a little time to create as this api will scrap and search in depth
     * The dataset id will be saved in db, which can be used after a specific period of time
     * schedule this once everyday
     */
    public function createDataset($channelId, $clientId, $keyword) {
        $sessionKey = "channel_".$channelId."__client_".$clientId;
        $authValue = Session::get($sessionKey);
        if (!(isset($authValue) && $authValue == "AUTH_OK")) {
            $this->authClient($channelId, $clientId, false);
        }
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->ScrapperApiEndpoint.'/v2/acts/'.$this->actor.'/runs?token='.$this->ScrapperApiToken,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "startUrls": [{
                    "url": "https://www.ebay.com/sch/i.html?_from=R40&_trksid=p2380057.m570.l1313&_nkw='.$keyword.'&_sacat=0"
                }],
                "maxItems": 50,
                "proxyConfig": {
                    "useApifyProxy": true
                },
                "debug": false
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $dump = json_decode($response);
        if (isset($dump->error)) {
            return $dump;
        }
        $datasetId = $dump->data->defaultDatasetId;

        // Ensure that we store only the latest StoreDataSetLimit number of datasets to avoid api failure as old datasets gets expired on apify
        $existingWhere = array(
            'client_id' => $clientId,
            'channel_id' => $channelId,
            'keyword' => $keyword,
            'dataset' => $datasetId,
        );
        $count = Datasets::where($existingWhere)->count();
        if ($count > $this->StoreDataSetLimit) {
            $oldestRecord = Datasets::where($existingWhere)->orderBy('created_at', 'asc')->first();
            if ($oldestRecord) {
                $oldestRecord->forceDelete();
            }
        }

        Datasets::create([
            'client_id' => $clientId,
            'channel_id' => $channelId,
            'keyword' => $keyword,
            'dataset' => $datasetId,
            'run_id' => $dump->data->id,
            'run_status' => $dump->data->status,
            // 'run_statusMessage' => $dump->data->statusMessage,
        ]);
        return $datasetId;
    }

    /**
     * Wait for createDataset to complete and create a dataset, then only call this function
     * This function fetch data from apify based on a particular dataset
     * This will save the data response in DB
     */
    public function saveData($channelId, $clientId, $keyword, $datasetId = "") {
        // print("ok");
        // die;
        $sessionKey = "channel_".$channelId."__client_".$clientId;
        $authValue = Session::get($sessionKey);
        if (!(isset($authValue) && $authValue == "AUTH_OK")) {
            $this->authClient($channelId, $clientId, false);
        }
        if ($datasetId == "") {
            $where = array(
                'client_id' => $clientId,
                'channel_id' => $channelId,
                'keyword' => $keyword,
                'run_status' => "SUCCEEDED",
            );
            $datasetData = Datasets::where($where)->orderBy("created_at", "desc")->first();
            if (!$datasetData) {
                return "Dataset id not found or is in pending state";
            }
            $datasetId = $datasetData->dataset;
        }

        $curl = curl_init();
        $url = $this->ScrapperApiEndpoint.'/v2/datasets/'.$datasetId.'/items?token='.$this->ScrapperApiToken;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $dumpResponse = json_decode($response);

        // basic validations of response
        if (isset($dumpResponse['error']) || isset($dumpResponse->error)) {
            return $dumpResponse;
        }
        if (isset($dumpResponse) && !empty($dumpResponse)) {
            $existingWhere = array(
                'client_id' => $clientId,
                'channel_id' => $channelId,
                'channel_name' => $this->channelName,
                'dataset' => $datasetId,
                'keyword' => $keyword
            );
            TKO_Ecommerce::where($existingWhere)->forceDelete();
        }
        $whitelistKey = "channel_".$channelId."__client_".$clientId."__whitelistKey";
        $whitelistValue = Session::get($whitelistKey);
        if (isset($whitelistValue) && $whitelistValue != "") {
            $whitelistValue = explode(",", $whitelistValue);
            $whitelistValue = array_map('trim', $whitelistValue);
        }
        // $this->pre($dumpResponse);
        // die;

        // TODO: NEED API_TOKEN for PRO PLAN FOR EBAY CHANNEL FROM APIFY
        // return $this->pre($dumpResponse);
        foreach ($dumpResponse as $dump) {
            $severity = "medium";
            foreach ($whitelistValue as $w) {
                if (stripos($dump->title, $w) != false) {
                    $severity = "low";
                    break;
                }
            }
            $data = array(
                "client_id" => $clientId,
                'channel_id'=> $channelId,
                'channel_name' => $this->channelName,
                'dataset' => $datasetId,
                'keyword' => $keyword,
                "url" => $dump->url,
                "title" => $dump->title,
                "price" => $dump->price,
                "image" => $dump->image,
                "seller" => $dump->seller,
                "brand" => $dump->brand,
            );
            // $this->pre($data);
            // continue;
            TKO_Ecommerce::create($data);
        }
        return "Success";
    }

}
