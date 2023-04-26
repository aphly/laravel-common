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
        Schema::create('common_category', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->string('cn_name',128)->nullable();
            $table->string('icon',255)->nullable();
            $table->integer('pid')->unsigned();
            $table->integer('sort')->unsigned()->nullable();
            $table->tinyInteger('type')->default(1);
            $table->tinyInteger('status');
            $table->string('meta_title',255)->nullable();
            $table->string('meta_description',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_category');
    }
};
