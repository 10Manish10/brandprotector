<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelSubscriptionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('channel_subscription', function (Blueprint $table) {
            $table->unsignedBigInteger('channel_id');
            $table->foreign('channel_id', 'channel_id_fk_8751448')->references('id')->on('channels')->onDelete('cascade');
            $table->unsignedBigInteger('subscription_id');
            $table->foreign('subscription_id', 'subscription_id_fk_8751448')->references('id')->on('subscriptions')->onDelete('cascade');
        });
    }
}
