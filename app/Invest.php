<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invest extends Model {
	
	public $timestamps = false;
	protected $fillable = ['user_ident', 'rate_ident', 'rate_name', 'inv_sum', 'fin_sum', 'percent', 'time', 'part_time', 'part_sum', 'part', 'parts', 'start', 'finish', 'status'];
	
}