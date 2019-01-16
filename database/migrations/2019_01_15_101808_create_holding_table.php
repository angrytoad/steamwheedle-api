<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHoldingTable extends Migration
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
            $table->uuid('item_id')->nullable();
            $table->string('name');
            $table->string('flavour');
            $table->string('zone');
            $table->string('image');
            $table->integer('required_level');
            $table->bigInteger('cost');
            $table->boolean('rent_upgrades_enabled')->default(true);
            $table->integer('rent_interval')->default(env('RENT_COLLECTION_INTERVAL'));
            $table->boolean('discount_upgrades_enabled')->default(true);
            $table->boolean('xp_upgrades_enabled')->default(true);

            $table->integer('rent_max_level')->default(env('RENT_MAX_LEVEL'));
            $table->float('rent_cost_increment')->default(env('RENT_COST_INCREMENT'));
            $table->float('rent_level_increment')->default(env('RENT_LEVEL_INCREMENT'));
            $table->integer('discount_max_level')->default(env('DISCOUNT_MAX_LEVEL'));
            $table->float('discount_cost_increment')->default(env('DISCOUNT_COST_INCREMENT'));
            $table->float('discount_level_increment')->default(env('DISCOUNT_LEVEL_INCREMENT'));
            $table->integer('xp_max_level')->default(env('XP_MAX_LEVEL'));
            $table->float('xp_cost_increment')->default(env('XP_COST_INCREMENT'));
            $table->float('xp_level_increment')->default(env('XP_LEVEL_INCREMENT'));

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
