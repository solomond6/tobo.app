<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Inspection extends Model
{
    
    protected $table ='inspections';

    const STATUS_APPROVED = 1;
    const STATUS_REJECTED = 2;

    protected $guarded = [];

    public function user(){
      return $this->belongsTo(User::class, 'user_id');
    }
}
