<?php

use Illuminate\Database\Seeder;
use App\Entities\{ Ticket, Payment };

class PaymentsTableSeeder extends Seeder
{
    /**
     * The minimum number of payments to seed.
     *
     * @var int
     */
    protected $minPayments = 2;

    /**
     * The maximum number of payments to seed. Will not exceed ticket count.
     *
     * @var int
     */
    protected $maxPayments = 8;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tickets = Ticket::all();
        $tickets = Ticket::all()->random(
        	random_int(
        		$this->minPayments,
        		$tickets->count() > $this->maxPayments
        			? $this->maxPayments
        			: $tickets->count() - 1
        	)
        );

        foreach($tickets as $ticket) {
        	$ticket->pay();
        }
    }
}
