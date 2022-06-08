@extends('layouts.adminlayoutVue')

@section('content')

<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"></h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Threads</a></li>
      <!-- <li class="breadcrumb-item active">{{__('words.category')}}</li>
      <li class="breadcrumb-item active">{{__('words.new')}}</li> -->
    </ol>
  </div><!-- /.col -->
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="card-title">
            <h1 class="m-0 text-dark h4">Create a New Post</h1>
        </div>
    </div>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
              {{ session('success') }}
            </div>
          @endif
          @if(session('error'))
            <div class="alert alert-danger">
              {{ session('error') }}
            </div>
          @endif
        <form method="POST" action='/threads' enctype="multipart/form-data">
            {{ csrf_field() }}

            <div class='form-group'>
                <label for='title'>Title:</label>
                <input type='text' class='form-control' name='title' value="{{ old('title') }}" required>
            </div>

            <div class='form-group'>
                <label for='body'>Body:</label>
                <textarea name='body' id='body' class='form-control' rows='8' required>{{ old('body') }}</textarea>
            </div>

            <div class='form-group'>
                <label for='body'>Images:</label>
                <input type="file" name="image[]" multiple class='form-control'>
            </div>

            <div class='form-group'>
                <button type='submit' class='btn btn-primary'>Publish</button>
            </div>
        
            @if(count($errors))
                <ul class='alert alert-danger'>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif
        </form>

    </div>
</div>
@endsection