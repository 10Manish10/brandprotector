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
        Schema::create('tko_ecommerce', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('client_id');
            $table->integer('channel_id');
            $table->string('channel_name')->nullable();
            $table->string('dataset')->nullable();
            $table->string('hash')->nullable();
            $table->string('severity')->enum('status', ['low', 'medium', 'high'])->default('medium');
            $table->string('keyword')->nullable();
            $table->string('url')->nullable();
            $table->string('title')->nullable();
            $table->dateTime('lastUpdated')->nullable();
            $table->string('price')->nullable();
            $table->string('image')->nullable();
            $table->string('seller')->nullable();
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            $table->string('categories')->nullable();
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
        Schema::dropIfExists('tko_ecommerce');
    }
};
