<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\UserDetails;
use App\Models\VerifyUser;
use Questocat\Referral\Traits\UserReferral;
use App\Models\Activity;
use App\Models\Reply;

class User extends Authenticatable
{
    use Notifiable;
    // use UserReferral;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password','status','affiliate_id', 'upline_0_id', 'upline_0_commission', 'commission', 'upline_1_id', 'upline_1_commission', 'upline_2_id', 'upline_2_commission'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function verifyUser()
    {
        return $this->hasOne(VerifyUser::class);
    }
    
    public function roles(){
      return $this->belongsToMany(Role::class);
    }

    public function authorizeRoles($roles){
      if (is_array($roles)) {
          return $this->hasAnyRole($roles) || 
                 abort(401, 'This action is unauthorized.');
      }
      return $this->hasRole($roles) || 
             abort(401, 'This action is unauthorized.');
    }

    public function hasAnyRole($roles){
      return null !== $this->roles()->whereIn('name', $roles)->first();
    }

    public function hasRole($role){
      return null !== $this->roles()->where('name', $role)->first();
    }

    public function referrer()
    {
        return $this->belongsTo(User::class, 'referrer_id', 'id');
    }

    /**
     * A user has many referrals.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referrer_id', 'id');
    }

    protected $appends = ['referral_link'];

    /**
     * Get the user's referral link.
     *
     * @return string
     */
    public function getReferralLinkAttribute()
    {
        return $this->referral_link = route('register', ['ref' => $this->affiliate_id]);
    }


    public function userdetails(){
        return $this->hasOne(UserDetails::class); 
    }

    public function threads()
    {
        // make database relationship and return threads in proper order
        return $this->hasMany(Thread::class)->latest();
    }

    // Get route key name for Laravel
    public function getRouteKeyName()
    {
        return 'name';
    }

    // Get all activity for the user
    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function images()
    {
        return $this->hasMany(UserImage::class);
    }

    public function coverImage()
    {
        return $this->hasOne(UserImage::class)
            ->orderByDesc('id')
            ->where('location', 'cover')
            ->withDefault(function ($userImage) {
                $userImage->path = '/user-images/cover-default-image.png';
            });
    }

    public function profileImage()
    {
        return $this->hasOne(UserImage::class)
            ->orderByDesc('id')
            ->where('location', 'profile')
            ->withDefault(function ($userImage) {
                $userImage->path = '/user-images/profile-default-image.jpeg';
            });
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'likes', 'user_id', 'post_id');
    }

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    
    public function upline()
    {
        return $this->belongsTo(User::class,'upline_0_id')->with('upline');
    }
    
    public function downline()
    {
        return $this->hasMany(User::class,'upline_0_id')->with('downline');
    }

    public function downline1()
    {
        return $this->downline('upline_1_id')->with('downline1');
    }


    public function downline2()
    {
        return $this->downline1('upline_2_id')->with('downline2');
    }
}

