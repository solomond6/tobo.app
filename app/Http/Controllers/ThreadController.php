<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Thread;
use App\Models\Channel;
use App\Models\PostImages;
use App\Filters\ThreadFilters;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class ThreadController extends Controller
{

    /**
     * Threads constructor
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Channel $channel, ThreadFilters $filters)
    {

        $threads = $this->getThreads($channel, $filters);

        if(request()->wantsJson()){
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
  
        $files = [];

        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'image.*' => 'image',
        ]);

        $post = Post::create([
            'user_id' => auth()->id(),
            'title' => request('title'),
            'body' => request('body')
        ]);

        $files = [];

        if($post){

            if($request->hasFile('image')){

                foreach($request->file('image') as $file)
                {
                    $name = time().rand(1,50).'.'.$file->extension();
                    $file->move(public_path('images/large/'), $name); 
                    
                    $postImage = new PostImages([
                        'image_path' => url('/images/large/').'/'.$name.'?ixlib=rails-2.1.4&auto=format&ch=Width%2CDPR&fit=max&w=935',
                    ]);

                    $post->postImages()->save($postImage);

                    //$files[] = $name;  
                }
            }

            return redirect('/admin/dashboard')->with('success', 'Your post has been published!');

        }else{
            return redirect()->back()->with('error', 'Error occcured, kindly try again.');
        }

        return redirect($thread->path())->with('success', 'Your post has been published!');
        
    }

    /**
     * Display the specified resource.
     */
    public function show($channel, Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($channel, Thread $thread)
    {
        // check that it is signed in user's thread
        // https://laravel.com/docs/5.4/authorization#via-controller-helpers
        $this->authorize('update', $thread);

        $thread->delete();

        if(request()->wantsJson()){
            return response([], 204);
        }
        
        return redirect('/threads');
    }

    // Fetch all relevant threads
    public function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);
        if($channel->exists){
            $threads->where('channel_id', $channel->id);
        }

        return $threads->get();
    }
}
