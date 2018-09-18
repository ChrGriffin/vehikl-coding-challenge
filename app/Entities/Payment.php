<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
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
    	'ticket_id', 'amount'
    ];

    /**
     * Decimal fields that should be converted to integers for storage.
     *
     * @var array
     */
    protected $convertableDecimals = [
    	'amount'
    ];

    /**
     * Relation to the Ticket model.
     */
    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}