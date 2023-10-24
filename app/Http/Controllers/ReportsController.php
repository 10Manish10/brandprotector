<?php

namespace App\Http\Controllers;

use App\Models\TKO_Ecommerce;
use app\Models\TKO_SearchEngine;
use app\Models\TKO_Social;
use App\Models\Client;
use App\Models\Channel;
use App\Models\Datasets;
use App\Models\Subscription;
use DB;
use Gate;
use App\Http\Controllers\AliExpressController;
use App\Http\Controllers\AmazonController;
use App\Http\Controllers\EbayController;
use App\Http\Controllers\EtsyController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\WalmartController;
use App\Http\Controllers\DatasetsScrap;

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
        abort_if(Gate::denies('reports_get'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $clients = Client::all();
        $channels = Channel::all();
        $data = [
            'clients' => $clients,
            'channels' => $channels,
            'reports' => []
        ];
        return view('reports', compact('data'));
    }

    public function getReport(Request $request, $clientId, $channelId, $cname, $keyword) {
        abort_if(Gate::denies('reports_get'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $dates = $request->query('date');
        $data = [];
        $where = [
            ['client_id', $clientId],
            ['channel_id', $channelId],
            ['keyword', $keyword]
        ];
        if ($dates != "") {
            $dateRangeParts = explode(' - ', $dates);
            if (count($dateRangeParts) === 2) {
                $fromDate = date_create_from_format('m/d/Y', $dateRangeParts[0]);
                $toDate = date_create_from_format('m/d/Y', $dateRangeParts[1]);
                date_time_set($fromDate, 0, 0, 0);
                date_time_set($toDate, 23, 59, 59);
                $from = date_format($fromDate, 'Y-m-d H:i:s');
                $to = date_format($toDate, 'Y-m-d H:i:s');
                $where[] = ['created_at', '>=', $from];
                $where[] = ['created_at', '<=', $to];
            }
        }
        // DB::connection()->enableQueryLog();
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
        // $queries = DB::getQueryLog();
        // return response()->json(['query' => $queries]);
        return response()->json($data);
    }

    protected function authReport($clientId) {
        $client = Client::where('id', $clientId)->orderBy('created_at', 'desc')->first();
        if (!$client) {
            return "invalid_client";
        }
        if ($client->payment_date == null && $client->payment == 0) {
            return "payment_due";
        }
        $plan = Subscription::where('id', $client->subplan)->orderBy('created_at', 'desc')->first();
        if (!$plan) {
            return "invalid_client";
        }

        $past = date('Y-m-d H:i:s', strtotime('-24 hours'));
        $current_usage = Datasets::where([
            ['client_id', $clientId],
            ['created_at', '>=', $past],
        ])->count('id');

        if ($current_usage >= $plan->api_hit_limit) {
            return "limit_exceed";
        }

        return "ok";
    }

    public function createReport($clientId, $channelId, $cname, $keyword) {
        abort_if(Gate::denies('reports_post'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = ["status" => "pending"];
        $status = $this->authReport($clientId);
        if (in_array($status, ["payment_due", "limit_exceed", "invalid_client"])) {
            $data["status"] = $status;
            return response()->json($data);
        }
        
        if ($status == "ok") {
            $cname = strtolower($cname);
            $cname = str_replace(' ', '_', $cname);
            $controller = "";
            switch ($cname) {
                case 'aliexpress':
                case 'ali_express':
                    $controller = new AliExpressController();
                    break;
                case 'amazon':
                    $controller = new AmazonController();
                    break;
                case 'ebay':
                    $controller = new EbayController();
                    break;
                case 'etsy':
                    $controller = new EtsyController();
                    break;
                case 'google':
                    $controller = new GoogleController();
                    break;
                case 'walmart':
                    $controller = new WalmartController();
                    break;
                default:
                    $data["status"] = "invalid_channel";
            }
            if ($controller != "") {
                $controller->authClient($channelId, $clientId, false);
                $controller->createDataset($channelId, $clientId, $keyword);
                $data["status"] = "success";
            }
        }
        return response()->json($data);
    }

}
