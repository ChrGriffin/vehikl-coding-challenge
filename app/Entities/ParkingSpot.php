<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ParkingSpot extends Model
{
    /**
     * Traits.
     */
    use Traits\HasDecimal;
    
    /**
     * Database fields that are 'fillable'.
     *
     * @var array
     */
    protected $fillable = [
    	'code', 'price', 'grid_x', 'grid_y', 'orientation'
    ];

    /**
     * Decimal fields that should be converted to integers for storage.
     *
     * @var array
     */
    protected $convertableDecimals = [
    	'price', 'grid_x', 'grid_y'
    ];

    /**
     * Define and return the is_available attribute.
     *
     * @return bool
     */
    public function getAvailableAttribute() : bool
    {
        $this->load('tickets');
        return $this->tickets
            ->filter(function ($ticket) {
                return empty($ticket->payment);
            })
            ->isEmpty();
    }

    /**
     * Relation to the Ticket model.
     *
     * @return
     */
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}