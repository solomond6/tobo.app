@extends('layouts.adminlayout')
@section('content')

<div class="card mb-4 col-6">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-10">
        <h6 class="m-0 font-weight-bold text-primary">Set Agent Commission</h6>
      </div>
      <div class="col-sm-2 text-right">
        <!-- <a href="{{ route('admin.sendinvite') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-plus"></i>  Back
        </a> -->
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


      {!! Form::open(['url'=>'/admin/sendinvite', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
        <div class="form-group has-feedback">
          {!! Form::label($user->user_firstname .' '. $user->user_lastname) !!}
          {!! Form::text('commission', $user->commission, ['class'=>'form-control', 'required'=> 'required']) !!}
        </div>
        <div class="form-group has-feedback">
          {!! Form::label($user->referral_first_name .' '. $user->referral_last_name) !!}
          {!! Form::text('commission', $user->commission, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group has-feedback">
          {!! Form::label($user->upline_1_last_name .' '. $user->upline_1_last_name) !!}
          {!! Form::text('commission', $user->upline_1_commission, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group has-feedback">
          {!! Form::label($user->upline_2_first_name .' '. $user->upline_2_last_name) !!}
          {!! Form::text('commission', $user->upline_2_commission, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
        </div>
      {!! Form::close() !!}
  </div>
</div>

@endsection