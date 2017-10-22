<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rate extends Model {
	public $timestamps = false;
	protected $fillable = ['name', 'min', 'max', 'percent', 'time', 'parts'];
}