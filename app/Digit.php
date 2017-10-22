<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Digit extends Model {
	public $timestamps = false;
	protected $fillable = ['ident', 'balance', 'replenished', 'invested', 'pay_by_inv', 'payment', 'widthdraw', 'actively', 'pending', 'pay_by_refs', 'pay_by_refback', 'spent_on_refback'];
}