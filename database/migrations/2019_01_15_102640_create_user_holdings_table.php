<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserHoldingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_holdings', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('user_id');
            $table->uuid('holding_id');
            $table->integer('rent_level')->default(0);
            $table->integer('discount_level')->default(0);
            $table->integer('xp_level')->default(0);
            $table->dateTime('last_collected_rent')->nullable();
            $table->bigInteger('copper_sank');
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
        Schema::dropIfExists('user_holdings');
    }
}
