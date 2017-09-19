<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	protected $characterSet = 'UTF-8';
	
	protected $flags = ENT_QUOTES;
}
