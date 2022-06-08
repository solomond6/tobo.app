<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\States;
use App\Models\Countries;
use App\Models\Cities;

class UserDetails extends Model
{
	protected $fillable = [
        'first_name', 'last_name', 'phone_no', 'whatsapp', 'email', 'address', 'address1', 'company_id', 'city_id', 'state_id', 'country_id'
    ];

    public function user(){
        return $this->belongsTo(User::class); 
    }

    public function states(){
	  return $this->belongsToMany(States::class);
	}

	public function countries(){
	  return $this->belongsToMany(Countries::class);
	}

	public function cities(){
	  return $this->belongsToMany(Cities::class);
	}
}
