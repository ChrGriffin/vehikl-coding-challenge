<?php

use Illuminate\Database\Seeder;
use App\Entities\TicketInterval;

class TicketIntervalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ticketIntervals = [
        	[
        		'interval'   => 3600, // one hour
        		'multiplier' => 0.5
        	], [
        		'interval'   => 3600 * 3,
        		'multiplier' => 0.5
        	], [
        		'interval'   => 3600 * 6,
        		'multiplier' => 0.5
        	], [
        		'interval'   => 3600 * 24,
        		'multiplier' => 0.5
        	]
        ];

        foreach($ticketIntervals as $ticketInterval) {
        	TicketInterval::create($ticketInterval);
        }
    }
}
