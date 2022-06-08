<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\PostImage as PostImageResource;

class Post extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // var_dump($this->PostImages);exit;
        return [
            'data' => [
                'type' => 'posts',
                'post_id' => $this->id,
                'attributes' => [
                    'posted_by' => new UserResource($this->user),
                    'likes' => new LikeCollection($this->likes),
                    'comments' => new CommentCollection($this->comments),
                    'title' => $this->title,
                    'body' => $this->body,
                    'post_image' => new PostImageResource($this->postImages),
                    'posted_at' => $this->created_at->diffForHumans(),
                ]
            ],
            'links' => [
                'self' => url('/posts/'.$this->id),
            ]
        ];
    }
}
