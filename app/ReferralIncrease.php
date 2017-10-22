<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralIncrease extends Model {
	public $timestamps = false;
	protected $fillable = ['from', 'percent'];
}