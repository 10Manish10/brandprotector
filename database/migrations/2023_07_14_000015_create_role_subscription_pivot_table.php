<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoleSubscriptionPivotTable extends Migration
{
    public function up()
    {
        Schema::create('role_subscription', function (Blueprint $table) {
            $table->unsignedBigInteger('subscription_id');
            $table->foreign('subscription_id', 'subscription_id_fk_8751446')->references('id')->on('subscriptions')->onDelete('cascade');
            $table->unsignedBigInteger('role_id');
            $table->foreign('role_id', 'role_id_fk_8751446')->references('id')->on('roles')->onDelete('cascade');
        });
    }
}
