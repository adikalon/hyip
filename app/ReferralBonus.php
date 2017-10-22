<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReferralBonus extends Model {
	
	public $timestamps = false;
	protected $fillable = ['user_ident', 'ref_ident', 'bonus', 'refback'];
	
}