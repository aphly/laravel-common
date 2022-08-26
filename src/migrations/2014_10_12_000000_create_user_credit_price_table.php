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
        Schema::create('common_credit_price', function (Blueprint $table) {
            $table->id();
            $table->string('credit_key',16);
            $table->unsignedBigInteger('credit_val');
            $table->decimal('price',10,2);
            $table->unsignedBigInteger('sort')->index();
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('common_credit_price');
    }
};
