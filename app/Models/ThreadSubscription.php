<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Notifications\ThreadWasUpdated;
use App\Models\User;
use App\Models\Thread;

class ThreadSubscription extends Model
{
	// the attributes that are not mass assignable
    protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function thread()
    {
    	return $this->belongsTo(Thread::class);
    }

    // send notification to user
    public function notify($reply)
    {
        $this->user->notify(new ThreadWasUpdated($this->thread, $reply));
    }
}
