<?php

namespace App\Http\Controllers;

use App\Models\TKO_Ecommerce;
use app\Models\TKO_SearchEngine;
use app\Models\TKO_Social;
use App\Models\Client;
use App\Models\Channel;
use DB;

use app\Http\Controllers\AliExpressController;
use app\Http\Controllers\AmazonController;
use app\Http\Controllers\EbayController;
use app\Http\Controllers\EtsyController;
use app\Http\Controllers\GoogleController;
use app\Http\Controllers\WalmartController;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReportsController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function pre($data) {
        echo "<pre>";
        print_r($data);
        echo "<pre>";
    }

    public function test() {
        $clients = Client::all();
        $channels = Channel::all();
        $data = [
            'clients' => $clients,
            'channels' => $channels,
            'reports' => []
        ];
        return view('reports', compact('data'));
    }

    public function getReport($clientId, $channelId, $cname, $keyword) {
        $data = [];
        $where = [
            'client_id' => $clientId,
            'channel_id' => $channelId,
            'keyword' => $keyword
        ];
        $cname = strtolower($cname);
        $cname = str_replace(' ', '_', $cname);
        switch ($cname) {
            case 'amazon':
            case 'aliexpress':
            case 'ali_express':
            case 'ebay':
            case 'etsy':
            case 'walmart':
                $data = TKO_Ecommerce::where($where)->orderBy('created_at', 'desc')->get();
                break;
            case 'google':
                $data = TKO_SearchEngine::where($where)->orderBy('created_at', 'desc')->get();
                break;
            case 'facebook':
            case 'tiktok':
            case 'twitter':
                $data = TKO_Social::where($where)->orderBy('created_at', 'desc')->get();
                break;
            default:
                $data = [];
        }
        return response()->json($data);
    }

}
