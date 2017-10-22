<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectWallet extends Model {
	public $timestamps = false;
	protected $fillable = ['ident', 'name', 'number'];
}