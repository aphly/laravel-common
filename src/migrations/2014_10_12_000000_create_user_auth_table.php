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
            $table->tinyInteger('verified')->default(0);
            $table->integer('last_login')->unsigned()->nullable();
            $table->string('last_ip',64)->nullable();
            $table->primary(['id_type','id']);
            $table->timestamps();
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