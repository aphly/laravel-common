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
        Schema::create('common_geo', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('country_id')->index();
            $table->unsignedInteger('zone_id')->nullable()->default(0)->index();
            $table->unsignedInteger('geo_group_id')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_geo');
    }
};
