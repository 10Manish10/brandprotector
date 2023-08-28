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
        $this->middleware('auth');
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

}
