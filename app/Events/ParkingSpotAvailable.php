<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use App\Entities\ParkingSpot;

class ParkingSpotAvailable implements ShouldBroadcastNow
{
    /**
     * Traits.
     */
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Newly available parking spot.
     *
     * @var ParkingSpot
     */
    public $parkingSpot;

    /**
     * Event constructor.
     *
     * @return void
     */
    public function __construct(ParkingSpot $parkingSpot)
    {
        $this->parkingSpot = $parkingSpot->code;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('parkingSpots');
    }
}
