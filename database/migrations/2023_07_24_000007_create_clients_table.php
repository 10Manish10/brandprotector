<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->longText('keywords');
            $table->string('website')->nullable();
            $table->string('brand_name');
            $table->string('social_handle')->nullable();
            $table->string('company_name')->unique();
            $table->longText('multiple_emails')->nullable();
            $table->string('variables');
            $table->unsignedBigInteger('subplan');
            $table->string('channels');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
