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
        Schema::create('common_user_group_order', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('uuid')->index();
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('month');
            $table->decimal('price',10,2);
            $table->decimal('total',10,2);
            $table->unsignedBigInteger('payment_id')->index();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_user_group_order');
    }
};
