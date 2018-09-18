<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingSpotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parking_spots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code');
            $table->unsignedInteger('price');
            $table->unsignedInteger('grid_x')->comment('Decimal conversion.');
            $table->unsignedInteger('grid_y')->comment('Decimal conversion.');
            $table->enum('orientation', ['horizontal', 'vertical'])->default('horizontal');
            $table->timestamps();

            $table->unique('code');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parking_spots');
    }
}
