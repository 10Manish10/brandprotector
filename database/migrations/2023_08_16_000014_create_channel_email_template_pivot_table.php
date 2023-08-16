<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelEmailTemplatePivotTable extends Migration
{
    public function up()
    {
        Schema::create('channel_email_template', function (Blueprint $table) {
            $table->unsignedBigInteger('email_template_id');
            $table->foreign('email_template_id', 'email_template_id_fk_8884312')->references('id')->on('email_templates')->onDelete('cascade');
            $table->unsignedBigInteger('channel_id');
            $table->foreign('channel_id', 'channel_id_fk_8884312')->references('id')->on('channels')->onDelete('cascade');
        });
    }
}
