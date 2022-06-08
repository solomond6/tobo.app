<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserBalance extends Model
{
    
    protected $table ='user_balance';

    protected $guarded = [];

    public function user(){
      return $this->belongsTo(User::class, 'user_id');
    }
}
