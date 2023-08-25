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
        Schema::create('common_user', function (Blueprint $table) {
            $table->unsignedBigInteger('uuid')->primary();
            $table->string('nickname',32)->index();
            $table->string('token',128)->index();
            $table->unsignedInteger('token_expire');
            $table->string('avatar',255)->nullable();
            $table->tinyInteger('remote')->default(0);
            $table->unsignedInteger('group_id')->nullable()->default(0);
            $table->unsignedInteger('group_expire')->nullable()->default(0);
            $table->unsignedInteger('address_id')->nullable()->default(0);
            $table->tinyInteger('status')->default(1)->comment('1:正常; 2:冻结');
            $table->tinyInteger('gender')->default(1);
            $table->tinyInteger('verified')->nullable()->default(0);
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
        Schema::dropIfExists('common_user');
    }
};
