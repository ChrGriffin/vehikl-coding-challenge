<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Picqer\Barcode\BarcodeGeneratorSVG as Barcode;
use App\Events\{ ParkingSpotReserved, ParkingSpotAvailable };
use Storage;

class Ticket extends Model
{
    /**
     * Database fields that are 'fillable'.
     *
     * @var array
     */
    protected $fillable = [
    	'parking_spot_id', 'code' 
    ];

    /**
	 * The "booting" method of the model.
	 *
	 * @return void
	 */
	protected static function boot()
	{
	    parent::boot();

	    // automatically create the ticket code on creation
	    static::creating(function ($model) {
	        $model->code = Uuid::uuid4()->toString();
	    });

	    // automatically create the ticket barcode on creation
	    static::created(function ($model) {
	        $barcode = (new Barcode)
	        	->getBarcode($model->code, Barcode::TYPE_CODE_128);

	        $path = 'barcodes/' . $model->code . '.svg';

	        Storage::disk('public')->put($path, $barcode);
	        File::create([
	        	'disk'            => 'public',
	        	'path'            => $path,
	        	'attachable_id'   => $model->id,
	        	'attachable_type' => self::class
	        ]);

	        event(new ParkingSpotReserved($model->parkingSpot));
	    });
	}

	/**
	 * Define and return the amount_due attribute.
	 *
	 * @return float
	 */
	public function getAmountDueAttribute() : float
	{
		$diffInSeconds = $this->stay_duration;

		if(!empty($this->payment)) {
			return 0;
		}
		else {
			$intervals = TicketInterval::where('interval', '<=', $diffInSeconds)->get();
			$price = $this->parkingSpot->price;

			foreach($intervals as $interval) {
				$price += ($price * $interval->multiplier);
			}

			return round($price, 2);
		}
	}

	/**
	 * Define and return the stay_duration attribute.
	 *
	 * @return int
	 */
	public function getStayDurationAttribute() : int
	{
		if(!empty($this->payment)) {
			// ticket was paid, stay duration was until ticket was paid
			return $this->created_at->diffInSeconds($this->payment->created_at);
		}
		else {
			// ticket is not yet paid, stay duration is ongoing
			return $this->created_at->diffInSeconds(now());
		}
	}

	/**
	 * Relation to the Payment model.
	 *
	 * @return
	 */
	public function payment()
	{
		return $this->hasOne(Payment::class);
	}

	/**
	 * Relation to the ParkingSpot model.
	 *
	 * @return
	 */
	public function parkingSpot()
	{
		return $this->belongsTo(ParkingSpot::class);
	}

	/**
	 * Polymorphic relation to the File model.
	 *
	 * @return
	 */
	public function barcode()
	{
		return $this->morphOne(File::class, 'attachable');
	}

	/**
	 * Pay the ticket.
	 * TODO: probably actually charge money at some point.
	 *
	 * @return bool
	 */
	public function pay() : bool
	{
		if(!empty($this->payment)) {
			return false;
		}

		Payment::create([
            'ticket_id' => $this->id,
            'amount'    => $this->amount_due
        ]);

        event(new ParkingSpotAvailable($this->parkingSpot));
        
        $this->load('payment');
        return true;
	}
}