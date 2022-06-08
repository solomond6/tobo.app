<?php

namespace App\Http\Controllers;


use App\Models\Friend;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostImage;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\PostCollection;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function index()
    {

        return new PostCollection(
            Post::get()
            );


    }

    public function store()
    {
        $data = request()->validate([
           'body' => '',
            'image' => '',
            'width' => '',
            'height' => '',
        ]);

        if (isset($data['image'])) {
            $image = $data['image']->store('post-images','public');

            Image::make($data['image'])->fit($data['width'],$data['height'])
                ->save(storage_path('app/public/post-images/'.$data['image']->hashName()));

        }

        $post = request()->user()->posts()->create([
            'body' => $data['body'],
            'image' => $image ?? null,
        ]);

        return new PostResource($post);


    }


}
