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
        Schema::create('common_currency', function (Blueprint $table) {
            $table->id();
            $table->string('name',32);
            $table->string('cn_name',128)->nullable();
            $table->string('timezone',128)->nullable();
            $table->string('code',3)->index();
            $table->string('symbol_left',12)->nullable();
            $table->string('symbol_right',12)->nullable();
            $table->char('decimal_place',1)->nullable();
            $table->decimal('value',15,8);
            $table->tinyInteger('status');
            $table->tinyInteger('default')->nullable()->default(2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_currency');
    }
};
