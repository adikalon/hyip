<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replenishment extends Model {
	public $timestamps = false;
	protected $fillable = ['ident', 'wallet', 'number', 'transaction', 'sum', 'status', 'date'];
}