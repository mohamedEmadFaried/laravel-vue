<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
	/**
	 * Don't auto-apply mass assignment protection.
	 * @var array
	 */
	protected $guarded = [];

	public function center()
    {
        return $this->belongsTo('App\Center', 'center_id');
    }
}
