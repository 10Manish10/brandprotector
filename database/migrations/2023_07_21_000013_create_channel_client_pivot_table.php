<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelClientPivotTable extends Migration
{
    public function up()
    {
        Schema::create('channel_client', function (Blueprint $table) {
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id', 'client_id_fk_8751341')->references('id')->on('clients')->onDelete('cascade');
            $table->unsignedBigInteger('channel_id');
            $table->foreign('channel_id', 'channel_id_fk_8751341')->references('id')->on('channels')->onDelete('cascade');
        });
    }
}
