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
        Schema::create('common_user_credit_log', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid');
            $table->char('pre',1);
            $table->string('key',16);
            $table->unsignedInteger('val')->nullable();
            $table->string('type',16);
            $table->string('reason',64);
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
        Schema::dropIfExists('common_user_credit_log');
    }
};
