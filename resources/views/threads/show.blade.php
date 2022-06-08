@extends('layouts.adminlayoutVue')
@section('content')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Thread</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <!-- <li class="breadcrumb-item active">{{__('words.staffs')}}</li> -->
    </ol>
  </div><!-- /.col -->
</div>

<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-2">
            <div class="card-header">
                <div class='d-flex'>
                    <div class="flex-grow-1">
                        <h4 class='card-title'>{{ $thread->title }}</h4>
                        <!-- Using a named route. Same as "/profiles/{{ $thread->creator->name }}" -->
                        Posted by <a href="">{{ $thread->creator->name }}</a>
                    </div>
                    @can('update', $thread)
                    <form action="{{$thread->path()}}" method='POST'>
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type='submit' class='btn btn-danger'>Delete Thread</button>
                    </form>
                    @endcan
                </div>
            </div>
            <div class="card-body">
                {{ $thread->body }}
            </div>
        </div>
        <replies @added='repliesCount++' @removed='repliesCount--'></replies>
    </div>

    <!-- <div class='col-md-4'>
        <div class="card">
            <div class="card-body">
                This thread was published {{ $thread->created_at->diffForHumans() }} by <a href=''>{{ $thread->creator->name }}</a> and currently has <span v-text='repliesCount'></span> {{ Str::plural('reply', $thread->replies_count) }}.
                <p>
                    <subscribe-button :subscribed="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                </p>

            </div>

        </div>
    </div> -->
</div>
</thread-view>
@endsection