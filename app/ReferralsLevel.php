<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralsLevel extends Model {
	public $timestamps = false;
	protected $fillable = ['percent'];
}