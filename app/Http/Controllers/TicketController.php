<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\{ ParkingSpot, Ticket };

class TicketController extends Controller
{
    /**
     * Create a new ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    	$request->validate([
            'code' => 'required'
        ]);

        $parkingSpot = ParkingSpot::where('code', $request->input('code'))
            ->firstOrFail();

        if(!$parkingSpot->available) {
            abort(400, 'Parking spot is not available.');
        }

        $ticket = Ticket::create([
            'parking_spot_id' => $parkingSpot->id
        ]);

        return response()->json([
            'parking_spot_code' => $parkingSpot->code,
            'ticket_code'       => $ticket->code,
            'barcode_url'       => $ticket->barcode->url
        ]);
    }

    /**
     * Get an existing ticket.
     *
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function status(string $code)
    {
        $ticket = $this->getUnpaidTicket($code);

        return response()->json([
            'stay_duration' => $ticket->created_at->diffInSeconds(now()),
            'amount_due'    => $ticket->amount_due
        ]);
    }

    /**
     * Pay a ticket.
     *
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function pay(string $code)
    {
        $ticket = $this->getUnpaidTicket($code);

        // TODO: actually charge something at some point
        if($ticket->pay()) {
            return response()->json([
                'stay_duration' => $ticket->created_at->diffInSeconds(now()),
                'amount_due'    => $ticket->amount_due
            ]);
        }
        else {
            abort(500, 'Could not pay ticket.');
        }
    }

    /**
     * Retrieve a ticket, aborting if it is unpaid.
     *
     * @param string $code
     * @return Ticket
     */
    private function getUnpaidTicket(string $code) : Ticket
    {
        $ticket = Ticket::where('code', $code)
            ->firstOrFail();

        if(!empty($ticket->payment)) {
            // TODO: Activate automated gun turrets. This individual is clearly messing with us.
            abort(400, 'Ticket has already been paid.');
        }

        return $ticket;
    }
}
