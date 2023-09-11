<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Client;
use App\Models\Amazon;
use Gate;
use DB;

use Illuminate\Http\Request;

class AmazonController extends Controller
{
    public function __construct() {
        // $this->middleware('auth');
    }

    public function pre($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public function authClient($channelId, $clientId) {
        $channel = Channel::where('id', $channelId)->first();
        if (!$channel) {
            abort(403, 'Invalid Channel');
        }
        $client = Client::where('id', $clientId)->first();
        if (!$client) {
            abort(403, 'Invalid Client');
        }
        $client->variables = unserialize($client->variables);
        $client->channels = unserialize($client->channels);
        $clientChannelIds = array_values($client->channels);
        if (!in_array($channelId, $clientChannelIds)) {
            abort(403, 'Unauthorized Access');
        }
        $channelName = array_flip($client->channels)[$channelId];
        $client->channelData = $client->variables[$channelName];
        return $client;
    }

    public function amazonCron($channelId, $clientId) {
        $client = $this->authClient($channelId, $clientId);
        $this->pre($client->channelData);

        // save this amazon api response to db
        $response = $this->getAmazonApiData($client->channelData);
        $data = array(
            'channelId' => $channelId,
            'clientId' => $clientId,
            'subscriptionId' => $client->subplan,
            'response' => serialize($response),
        );
        // Amazon::create($data);
        return true;
    }

    public function getAmazonApiData($data) {
        // code here
        return 1;
    }

    public function api1() {
        // code here
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.apify.com/v2/acts/apify~google-search-scraper/runs?token=apify_api_vK1lucp5XQsj7czpM1mMLoF60idnkk4aoCmj',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "queries": "revlon",
                "maxPagesPerQuery": 1,
                "resultsPerPage": 100,
                "mobileResults": false,
                "languageCode": "",
                "maxConcurrency": 10,
                "saveHtml": false,
                "saveHtmlToKeyValueStore": false,
                "includeUnfilteredResults": false,
                "customDataFunction": ""
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $dump = json_decode($response);
        $datasetId = $dump->data->defaultDatasetId;
        return $datasetId;
    }

    public function api2($datasetId) {
        $curl2 = curl_init();
        $url2 = 'https://api.apify.com/v2/datasets/' . $datasetId . '/items?format=json&fields=searchQuery,organicResults&unwind=organicResults';
        curl_setopt_array($curl2, array(
            CURLOPT_URL => $url2,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response2 = curl_exec($curl2);
        curl_close($curl2);
        $dump2 = json_decode($response2);
        dd($dump2);
        return 1;
    }

}
