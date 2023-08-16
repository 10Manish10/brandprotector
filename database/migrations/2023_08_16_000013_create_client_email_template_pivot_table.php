<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientEmailTemplatePivotTable extends Migration
{
    public function up()
    {
        Schema::create('client_email_template', function (Blueprint $table) {
            $table->unsignedBigInteger('email_template_id');
            $table->foreign('email_template_id', 'email_template_id_fk_8751376')->references('id')->on('email_templates')->onDelete('cascade');
            $table->unsignedBigInteger('client_id');
            $table->foreign('client_id', 'client_id_fk_8751376')->references('id')->on('clients')->onDelete('cascade');
        });
    }
}
