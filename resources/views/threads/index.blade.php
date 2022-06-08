@extends('layouts.adminlayoutVue')

@section('content')
<div class="row">
    <div class="col-md-12">
        @forelse($threads as $thread)
        <div class="card mb-2">
            <div class="card-header">
                <div class='d-flex'>
                    <h4 class='card-title flex-grow-1'>
                        <a href='{{ $thread->path() }}'>{{ $thread->title }}</a>
                    </h4>
                    <strong>
                        <a href="{{ $thread->path()}}">{{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count)}}</a>
                    </strong>
                </div>
            </div>

            <div class="card-body">
                <div class='body'>
                    {{ $thread->body }}
                </div>
            </div>
        </div>
        @empty
        <p>There are no threads in this category yet. <a href='/topics/create'>Create one!</a></p>
        @endforelse
    </div>
</div>
@endsection