<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tko_searchengine', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_id');
            $table->integer('channel_id');
            $table->string('channel_name')->nullable();
            $table->string('dataset')->nullable();
            $table->string('hash')->nullable();
            $table->string('severity')->enum('status', ['low', 'medium', 'high'])->default('medium');
            $table->string('keyword')->nullable();
            $table->string('title')->nullable();
            $table->string('url')->nullable();
            $table->string('result_type')->nullable();
            $table->string('result_type_title')->nullable();
            $table->string('result_type_url')->nullable();
            $table->string('result_type_displayurl')->nullable();
            $table->string('sid_1')->nullable();
            $table->string('sid_2')->nullable();
            $table->string('sid_3')->nullable();
            $table->string('sid_4')->nullable();
            $table->string('sid_5')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tko_searchengine');
    }
};
