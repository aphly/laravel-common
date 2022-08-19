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
            $table->integer('sort')->index();
            $table->decimal('price',10,2)->nullable()->default(0);
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
