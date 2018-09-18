<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Entities\ParkingSpot;
use JavaScript;

class AppController extends Controller
{
    /**
     * Show the landing page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    	JavaScript::put([
            'ticketSubmitUrl' => route('ticket.create'),
            'ticketGetUrl'    => route('ticket.status', ['code' => null]),
            'ticketPayUrl'    => route('ticket.pay', ['code' => null])
        ]);

        return view('app', [
    		'parkingSpots' => ParkingSpot::all()
    	]);
    }
}
