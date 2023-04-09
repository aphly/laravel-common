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
        Schema::create('common_category_path', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->index();
            $table->integer('path_id')->unsigned()->index();
            $table->integer('level')->unsigned();
            $table->primary(['category_id','path_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_category_path');
    }
};
