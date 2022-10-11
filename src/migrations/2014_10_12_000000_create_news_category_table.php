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
        Schema::create('common_news_category', function (Blueprint $table) {
            $table->id();
            $table->string('name',64);
            $table->string('icon',255)->nullable();
            $table->integer('pid')->unsigned()->index();
            $table->integer('sort')->unsigned()->index()->nullable();
            $table->tinyInteger('is_leaf')->default(1)->index();
            $table->tinyInteger('status')->index();
            $table->text('description')->nullable();
            $table->string('meta_title',255)->nullable();
            $table->string('meta_keyword',255)->nullable();
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
        Schema::dropIfExists('common_news_category');
    }
};
