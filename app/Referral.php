<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Referral extends Model {
	
	public $timestamps = false;
	protected $fillable = ['ident', 'referral', 'level', 'refback'];
	
}