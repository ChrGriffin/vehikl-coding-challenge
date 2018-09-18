<?php

use Illuminate\Database\Seeder;
use App\Entities\{ ParkingSpot, Ticket };

class TicketsTableSeeder extends Seeder
{
    /**
     * The minimum number of tickets to seed.
     *
     * @var int
     */
    protected $minTickets = 12;

    /**
     * The maximum number of tickets to seed. Will not exceed parking spot count.
     *
     * @var int
     */
    protected $maxTickets = 24;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parkingSpots = ParkingSpot::all();
        $parkingSpots = ParkingSpot::all()->random(
        	random_int(
        		$this->minTickets,
        		$parkingSpots->count() > $this->maxTickets
        			? $this->maxTickets
        			: $parkingSpots->count() - 1
        	)
        );

        foreach($parkingSpots as $parkingSpot) {
        	Ticket::create(['parking_spot_id' => $parkingSpot->id]);
        }
    }
}
