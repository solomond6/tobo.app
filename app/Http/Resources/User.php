<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Friend;
use App\Http\Resources\Friend as FriendResource;
use App\Http\Resources\UserImage as UserImageResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'type' => 'users',
                'user_id' => $this->id,
                'attributes' => [
                    'name' => $this->name,
                    'user_name' => $this->username,
                    'friendship' => new FriendResource(Friend::friendship($this->id)),
                    'cover_image' => new UserImageResource($this->coverImage),
                    'profile_image' => new UserImageResource($this->profileImage),

                ]],
            'links' => [
                'self' => url('/users/'.$this->id),
            ]
        ];
    }
}
