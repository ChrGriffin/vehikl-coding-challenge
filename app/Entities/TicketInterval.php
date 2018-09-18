<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class TicketInterval extends Model
{
    /**
     * Traits.
     */
    use Traits\HasDecimal;

    /**
     * Decimal fields that should be converted to integers for storage.
     *
     * @var array
     */
    protected $convertableDecimals = [
    	'multiplier'
    ];

    /**
     * Database fields that are 'fillable'.
     *
     * @var array
     */
    protected $fillable = [
    	'interval', 'multiplier'
    ];
}