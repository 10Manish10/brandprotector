<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ScrapperStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dataset:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will update dataset status from api';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new \App\Http\Controllers\DatasetsScrap;
        $controller->updateStatus();
        $this->info("Dataset update success");
    }
}
