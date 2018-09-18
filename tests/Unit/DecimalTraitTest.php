<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Entities\{ ParkingSpot, Payment, TicketInterval };
use DB;

class DecimalTraitTest extends TestCase
{
    /**
     * Test that the Parking Spot decimals are being correctly transformed.
     *
     * @return void
     */
    public function testParkingSpotDecimalTransforms()
    {
        $this->decimalFieldsTest(
            ParkingSpot::class,
            ['price', 'grid_x', 'grid_y']
        );
    }

    /**
     * Test that the Payment decimals are being correctly transformed.
     *
     * @return void
     */
    public function testPaymentDecimalTransforms()
    {
        $this->decimalFieldsTest(
            Payment::class,
            ['amount']
        );
    }

    /**
     * Test that the TicketInterval decimals are being correctly transformed.
     *
     * @return void
     */
    public function testTicketIntervalTransforms()
    {
        $this->decimalFieldsTest(
            TicketInterval::class,
            ['multiplier']
        );
    }

    /**
     * Test a given model's decimal fields.
     *
     * @return void
     */
    private function decimalFieldsTest($modelClass, $fields)
    {
        $query = DB::table((new $modelClass())->getTable());
        $query->select('id');
        foreach($fields as $field) {
            $query->addSelect($field);
        }

        $raw = $query->get()->random();
        $model = $modelClass::find($raw->id);

        foreach($fields as $field) {
            $this->assertEquals($raw->{$field}, $model->{$field} * 100);
        }
    }
}
