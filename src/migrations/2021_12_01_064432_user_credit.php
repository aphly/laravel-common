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
        Schema::create('common_user_credit', function (Blueprint $table) {
            $table->unsignedBigInteger('uuid')->primary();
            $table->unsignedInteger('point')->nullable()->default(0);
            $table->unsignedInteger('silver')->nullable()->default(0);
            $table->unsignedInteger('gold')->nullable()->default(0);
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('common_user_credit');
    }
};
