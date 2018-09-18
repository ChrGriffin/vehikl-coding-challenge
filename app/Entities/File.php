<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Storage;

class File extends Model
{
    /**
     * Database fields that are 'fillable'.
     *
     * @var array
     */
    protected $fillable = [
    	'disk', 'path', 'attachable_id', 'attachable_type' 
    ];

    /**
     * Polymorphic relation.
     *
     * @return
     */
    public function attachable()
    {
    	return $this->morphTo();
    }

    /**
     * Define and return the url attribute.
     *
     * @return string
     */
    public function getUrlAttribute() : string
    {
    	// TODO: expand if more file systems are used
    	switch($this->disk) {
    		case 'public':
    			return asset('storage/' . $this->path);
    	}
    }

    /**
     * Define and return the path attribute.
     *
     * @return string
     */
    public function getFullPathAttribute() : string
    {
        return Storage::disk($this->disk)
            ->path($this->path);
    }
}
