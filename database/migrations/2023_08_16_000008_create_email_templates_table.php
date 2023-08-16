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
            $table->string('subject');
            $table->longText('email_body');
            $table->string('priority');
            $table->string('from_email');
            $table->string('to_email');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
