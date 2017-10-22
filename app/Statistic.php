<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statistic extends Model {
	public $timestamps = false;
	protected $fillable = ['replenished', 'invested', 'balance', 'balance', 'paidout', 'registered', 'active'];
}