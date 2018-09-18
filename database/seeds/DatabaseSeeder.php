<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ParkingSpotsTableSeeder::class);
        $this->call(TicketIntervalsTableSeeder::class);
        $this->call(TicketsTableSeeder::class);
        $this->call(PaymentsTableSeeder::class);
    }
}
