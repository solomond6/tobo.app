<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Model\Thread;

class ThreadImages extends Model
{
	protected $fillable = ['image_path'];

    public function threads(){
        return $this->belongsTo(Thread::class); 
    }
}
