<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Center extends Model
{
	/**
	 * Don't auto-apply mass assignment protection.
	 * @var array
	 */
	protected $guarded = [];
	public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
