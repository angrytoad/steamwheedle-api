<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoldingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('holdings', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('item_id');
            $table->string('name');
            $table->string('flavour');
            $table->string('zone');
            $table->string('image');
            $table->integer('required_level');
            $table->bigInteger('cost');
            $table->boolean('rent_upgrades_enabled')->default(true);
            $table->integer('rent_interval')->default(env('RENT_COLLECTION_INTERVAL'));
            $table->boolean('discount_upgrades_available')->default(true);
            $table->boolean('xp_upgrades_available')->default(true);
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
        Schema::dropIfExists('holdings');
    }
}
