<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCategoriesAndCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->bigInteger('balance')->default(500);
        });
        Schema::table('items', function (Blueprint $table) {
            $table->uuid('category_id');
        });
        Schema::create('categories', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name');
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
        Schema::dropIfExists('categories');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('balance');
        });
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn('category_id');
        });
    }
}
