<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Sales extends Model
{
    
    protected $table ='sales';

    protected $guarded = [];

    public function user(){
      return $this->belongsTo(User::class, 'user_id');
    }
}
