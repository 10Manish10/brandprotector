<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailTemplatesTable extends Migration
{
    public function up()
    {
        Schema::create('email_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject')->nullable();
            $table->longText('email_body')->nullable();
            $table->string('priority')->nullable();
            $table->string('from_email')->nullable();
            $table->string('to_email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
