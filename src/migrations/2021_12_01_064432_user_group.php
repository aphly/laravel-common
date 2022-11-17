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
        Schema::create('common_group', function (Blueprint $table) {
            $table->id();
            $table->string('name',128);
            $table->string('cn_name',128)->nullable();
            $table->integer('sort')->index();
            $table->decimal('price',15,2)->nullable()->default(0);
            $table->tinyInteger('status')->nullable()->default(1)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_group');
    }
};
