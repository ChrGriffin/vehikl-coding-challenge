<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\{ ParkingSpot, Ticket };

class ParkingSpotTest extends TestCase
{
    /**
     * Test that the Parking Spot available attribute is properly defined.
     *
     * @return void
     */
    public function testParkingSpotAvailableAttributeWorks()
    {
        $parkingSpot = ParkingSpot::create([
            'code'   => 'TEST1',
            'price'  => 0,
            'grid_x' => 0,
            'grid_y' => 0
        ]);

        $this->assertTrue($parkingSpot->available);

        Ticket::create(['parking_spot_id' => $parkingSpot->id]);
        $this->assertFalse($parkingSpot->available);
    }
}
