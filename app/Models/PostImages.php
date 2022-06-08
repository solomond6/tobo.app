<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Model\Post;

class PostImages extends Model
{
	protected $fillable = ['image_path'];

    public function posts(){
        return $this->belongsTo(Post::class); 
    }
}
