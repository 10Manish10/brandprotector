<?php

namespace App\Http\Controllers;

use App\Models\Datasets;

use Illuminate\Http\Request;

class DatasetsScrap extends Controller
{
    private $ScrapperApiToken;
    private $ScrapperApiEndpoint;
    
    public function __construct() {
        $this->ScrapperApiToken = env("ScrapperApiToken", "");
        $this->ScrapperApiEndpoint = env("ScrapperApiEndpoint", "");
    }

    /**
     * This function will update the pending statuses of the dataset runs 
     * schedule this every 2 hours
     */
    public function updateStatus($runId = "") {
        if ($runId == "") {
            $existingData = Datasets::where('run_status', '!=', "SUCCEEDED")->limit(10)->get();
            // only push multiple records in queue, if direct call then do as usual
            foreach ($existingData as $data) {
                $this->consume($data->run_id, $existingData->run_status);
            }
        } else {
            $existingData = Datasets::where('run_id', $runId)->first();
            $this->consume($existingData->run_id, $existingData->run_status);
        }
        return true;
    }

    // TODO: connect with queue and make separate producer and consumer for this to rate limit api
    public function consume($runId, $existingStatus) {
        $curl = curl_init();
        $url = $this->ScrapperApiEndpoint.'/v2/actor-runs/'.$runId.'?token='.$this->ScrapperApiToken;
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
        
        if ($dumpResponse->data->status != $existingStatus) {
            Datasets::where('run_id', $runId)->update([
                'run_status' => $dumpResponse->data->status,
                'run_statusMessage' => isset($dumpResponse->data->statusMessage) ? $dumpResponse->data->statusMessage : "",
            ]);
        }
        return true;
    }

}
