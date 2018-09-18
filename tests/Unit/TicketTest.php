<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\{ ParkingSpot, Ticket, TicketInterval };
use Storage;

class TicketTest extends TestCase
{
    /**
     * Test that the Ticket stay_duration attribute is properly defined.
     *
     * @return void
     */
    public function testStayDurationAttributeWorks()
    {
        $ticket = $this->createTicket();

        $this->compareNumberWithTolerance(
            now()->diffInSeconds($ticket->created_at),
            $ticket->stay_duration
        );

        $ticket->created_at = $ticket->created_at->subHours(1);

        $this->compareNumberWithTolerance(
            now()->diffInSeconds($ticket->created_at),
            $ticket->stay_duration
        );

        $ticket->created_at = $ticket->created_at->subHours(24);

        $this->compareNumberWithTolerance(
            now()->diffInSeconds($ticket->created_at),
            $ticket->stay_duration
        );
    }

    /**
     * Test that the Ticket amount_due attribute is properly defined.
     *
     * @return void
     */
    public function testAmountDueAttributeWorks()
    {
        $ticket = $this->createTicket();

        $this->assertEquals($ticket->amount_due, $ticket->parkingSpot->price);

        $lastAmountDue = $ticket->amount_due;
        foreach(TicketInterval::all() as $interval) {
            $ticket->created_at = now()->subSeconds($interval->interval + 1);
            $this->assertTrue($ticket->amount_due >= $lastAmountDue);
            $lastAmountDue = $ticket->amount_due;
        }
    }

    /**
     * Test that an unpaid Ticket can be paid.
     *
     * @return void
     */
    public function testCanPayForUnpaidTicket()
    {
        $ticket = $this->createTicket();

        $this->assertEmpty($ticket->payment);
        $this->assertTrue($ticket->pay());
        $this->assertNotEmpty($ticket->payment);
    }

    /**
     * Test that a paid Ticket cannot be paid again.
     *
     * @return void
     */
    public function testCannotPayForPaidTicket()
    {
        $ticket = $this->createTicket();
        $ticket->pay();

        $this->assertFalse($ticket->pay());
    }

    /**
     * Test that once created, a Ticket properly creates a barcode image.
     *
     * @return void
     */
    public function testBarcodeFileExists()
    {
        $ticket = $this->createTicket();
        $this->assertFileExists($ticket->barcode->full_path);
    }

    /**
     * Create a new ticket for testing.
     */
    private function createTicket() : Ticket
    {
        $parkingSpot = ParkingSpot::all()->random();
        return Ticket::create([
            'parking_spot_id' => $parkingSpot->id
        ]);
    }

    /**
     * Compare two numbers with a specific tolerance for discrepancy.
     * ie., to account for potentially a slow database connection.
     *
     * @param int $original
     * @param int $compare
     * @param int $tolerance
     * @return void
     */
    private function compareNumberWithTolerance(int $original, int $compare, int $tolerance = 1)
    {
        $this->assertLessThan($tolerance + 1, ($compare - $original));
    }
}
