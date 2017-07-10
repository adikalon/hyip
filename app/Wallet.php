<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model {

	public $timestamps = false;
	protected $fillable = ['ident', 'qiwi', 'payeer'];

}