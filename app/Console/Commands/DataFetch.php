<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use \App\Models\Datasets;
use \App\Models\Channel;

class DataFetch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will fetch the data from datasets that are present in database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $currentTime = date('Y-m-d H:i:s');
        $twentyFourHoursAgo = date('Y-m-d H:i:s', strtotime('-24 hours', strtotime($currentTime)));

        $results = Datasets::select('channel_id', 'client_id', 'keyword', 'dataset')
        ->where('run_status', '=', 'SUCCEEDED')
        ->where('created_at', '>=', $twentyFourHoursAgo)
        ->get();

        $channels = Channel::pluck('channel_name', 'id')->toArray();
        // print_r(isset($channels[1]));

        foreach ($results as $result) {
            $channelId = $result->channel_id;
            $clientId = $result->client_id;
            $keyword = $result->keyword;
            $dataset = $result->dataset;
            $cname = $channels[$channelId];
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
            }
            if ($controller != "") {
                $controller->saveData($channelId, $clientId, $keyword, $dataset);
            }
        }
        
        $this->info("Data Fetch run success");
    }
}
