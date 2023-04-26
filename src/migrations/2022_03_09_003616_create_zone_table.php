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
        Schema::create('common_zone', function (Blueprint $table) {
            $table->id();
            $table->integer('country_id')->unsigned()->index();
            $table->string('name',128)->index();
            $table->string('cn_name',128)->nullable();
            $table->string('code',32);
            $table->tinyInteger('status')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_zone');
    }
};
