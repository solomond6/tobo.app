<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\UserDetails;

class Countries extends Model
{
    public function userdetails(){
        return $this->hasMany(UserDetails::class); 
    }
}
