<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model {
	public $timestamps = false;
	protected $fillable = ['ident', 'sum', 'wallet', 'number', 'message', 'date', 'date_accepted', 'status'];
}