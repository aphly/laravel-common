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
        Schema::create('common_country', function (Blueprint $table) {
            $table->id();
            $table->string('name',128);
            $table->string('cn_name',128)->nullable();
            $table->string('iso_code_2',2);
            $table->string('iso_code_3',3);
            $table->string('address_format',255)->nullable();
            $table->tinyInteger('postcode_required');
            $table->tinyInteger('status')->default(1)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_country');
    }
};
