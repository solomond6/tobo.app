<?php

namespace App\Models;

use App\Scopes\ReverseScope;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ReverseScope());
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes','post_id', 'user_id');

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function postImages()
    {
        return $this->hasMany(PostImages::class);
    }

    // public function postImages(){
    //     return $this->belongsToMany(PostImage::class, 'post_images','post_id');
    // }
}
