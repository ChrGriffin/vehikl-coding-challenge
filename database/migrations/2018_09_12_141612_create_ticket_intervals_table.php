<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTicketIntervalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_intervals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('interval')->nullable(false)->comment('Time interval in seconds.');
            $table->unsignedInteger('multiplier')->nullable(false)->default(0)->comment('Decimal conversion.');
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
        Schema::dropIfExists('ticket_intervals');
    }
}
