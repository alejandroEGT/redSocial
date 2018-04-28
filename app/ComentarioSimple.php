<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ComentarioSimple extends Model
{
    protected $table="comentario_simple";

   /* public function getLicenseExpireAttribute($date)
	{
	    return Carbon::parse($date)->diff('Y-m-d');
	}*/

	
}
