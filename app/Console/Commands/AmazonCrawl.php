<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Models\Client;
use App\Models\Channel;

class AmazonCrawl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'amazon:crawl {clientIds}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command used to crawl amazon data based on client ids provided';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $cids = $this->argument('clientIds');
        if (!$cids) return;
        $cids = explode(',', $cids);
        $clients = Client::whereIn('id', $cids)->pluck('keywords', 'id');
        $channel = Channel::where('channel_name', 'amazon')->orderBy('created_at', 'desc')->limit(1)->select('id')->first();
        $controller = new \App\Http\Controllers\AmazonController;

        // TODO: limit this code to run only if client payment is ok and it's rate limit is not reached
        foreach ($clients as $id => $keywords) {
            $keywords = explode(",", strip_tags($keywords));
            foreach ($keywords as $keyword) {
                // $controller->createDataset($channel->id, $id, trim($keyword));
            }
        }

        $this->info("Amazon cron run success");
    }
}
