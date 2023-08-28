<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AmazonFields extends Migration
{
    public function up()
    {
        Schema::create('amazon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('channelId');
            $table->integer('clientId');
            $table->integer('subscriptionId');
            $table->longText('response')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
