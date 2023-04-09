<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('common_user_auth', function (Blueprint $table) {
            $table->char('id_type',16);
            $table->string('id',128);
            $table->string('password',255);
            $table->unsignedBigInteger('uuid')->index();
            $table->string('last_ip',64)->nullable();
            $table->unsignedBigInteger('last_time')->nullable();
            $table->string('note',255)->nullable();
            $table->string('user_agent',255)->nullable();
            $table->string('accept_language',255)->nullable();
            $table->primary(['id_type','id']);
            $table->unsignedBigInteger('created_at');
            $table->unsignedBigInteger('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_user_auth');
    }
};
