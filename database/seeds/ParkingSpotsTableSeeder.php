<?php

use Illuminate\Database\Seeder;
use App\Entities\ParkingSpot;

class ParkingSpotsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $parkingSpots = [];
        $yGutter = 9;
        $xGutter = 7;

        // top row
        $x = 1;
        for($i = 12; $i <= 82; $i += $xGutter) {
        	$parkingSpots[] = [
                'code'        => 'A' . $x,
                'price'       => 3,
        		'grid_x'      => $i,
        		'grid_y'      => 1,
        		'orientation' => 'vertical'
        	];
            $x++;
        }

        // top middle row
        $x = 1;
        for($i = 26; $i <= 68; $i += $xGutter) {
        	$parkingSpots[] = [
                'code'        => 'B' . $x,
                'price'       => 3,
        		'grid_x'      => $i,
        		'grid_y'      => 36,
        		'orientation' => 'vertical'
        	];
            $x++;
        }

        // bottom middle row
        for($i = 26; $i <= 68; $i += $xGutter) {
        	$parkingSpots[] = [
                'code'        => 'B' . $x,
                'price'       => 3,
        		'grid_x'      => $i,
        		'grid_y'      => 52,
        		'orientation' => 'vertical'
        	];
            $x++;
        }

        // bottom row left half
        $x = 1;
        for($i = 12; $i <= 33; $i += $xGutter) {
        	$parkingSpots[] = [
                'code'        => 'C' . $x,
                'price'       => 3,
        		'grid_x'      => $i,
        		'grid_y'      => 85,
        		'orientation' => 'vertical'
        	];
            $x++;
        }

        // bottom row right half
        for($i = 61; $i <= 82; $i += $xGutter) {
        	$parkingSpots[] = [
                'code'        => 'C' . $x,
                'price'       => 3,
        		'grid_x'      => $i,
        		'grid_y'      => 85,
        		'orientation' => 'vertical'
        	];
            $x++;
        }

        // left column
        $x = 1;
        for($i = 28; $i <= 73; $i += $yGutter) {
        	$parkingSpots[] = [
                'code'        => 'D' . $x,
                'price'       => 3,
        		'grid_x'      => 1,
        		'grid_y'      => $i,
        		'orientation' => 'horizontal'
        	];
            $x++;
        }

        // right column
        $x = 1;
        for($i = 19; $i <= 73; $i += $yGutter) {
        	$parkingSpots[] = [
                'code'        => 'E' . $x,
                'price'       => 3,
        		'grid_x'      => 89,
        		'grid_y'      => $i,
        		'orientation' => 'horizontal'
        	];
            $x++;
        }

        foreach($parkingSpots as $parkingSpot) {
        	ParkingSpot::create($parkingSpot);
        }
    }
}
