<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\UserDetails;

class Cities extends Model
{
    public function states(){
	  return $this->belongsToMany(States::class);
	}

	// public function userdetails(){
 //        return $this->hasMany(UserDetails::class); 
 //    }
}
