@extends('layouts.agentlayout')
@section('content')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Sales</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Sales</a></li>
      <!-- <li class="breadcrumb-item active">{{__('words.category')}}</li>
      <li class="breadcrumb-item active">{{__('words.new')}}</li> -->
    </ol>
  </div><!-- /.col -->
</div>

<div class="card shadow mb-4 col-6">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-10">
        <h6 class="m-0 font-weight-bold text-primary"></h6>
      </div>
      <div class="col-sm-2 text-right">
        
      </div>
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
      {!! Form::open(['url'=>'/agent/sales/new', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
      <div class="form-group has-feedback">
        {!! Form::label('Property') !!}
        {!! Form::select('property_id', [1=>'Property 1',2=>'Property 2',3=>'Property 3',4=>'Property 4'], '0', ['class'=>'form-control', 'placeholder'=>'Select A Property']) !!}
      </div>
      <div class="form-group has-feedback">
        {!! Form::label('Price') !!}
        {!! Form::text('price', null, ['class'=>'form-control', 'required'=> 'required']) !!}
      </div>
      <div class="form-group">
        {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
      </div>
    {!! Form::close() !!}
  </div>
</div>

@endsection