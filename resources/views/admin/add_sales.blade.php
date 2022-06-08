@extends('layouts.adminlayout')
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

<div class="card shadow mb-4 col-12">
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
      {!! Form::open(['url'=>'/admin/sales/new', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
  
      <div class="row mb-4">
        <h2 class="col-12">Parties information</h2>
        <div class="col-3">
          {!! Form::label('Client Name') !!}
          {!! Form::text('client_name', null, ['class'=>'form-control', 'placeholder'=>'Enter Client Name']) !!}
        </div>
        <div class="col-4">
          {!! Form::label('Property') !!}
          {!! Form::select('property_id', [1=>'Property 1',2=>'Property 2',3=>'Property 3',4=>'Property 4'], '0', ['class'=>'form-control', 'placeholder'=>'Select A Property']) !!}
        </div>
        <div class="col-5">
          {!! Form::label('Sales Agent') !!}
          {!! Form::select('agent_id', $agents, 0, ['class'=>'form-control', 'required'=> 'required']) !!}
        </div>
      </div>
      <hr/>
      <div class="row mb-4">
        <h2 class="col-12">Sales information</h2>
        <div class="col-3">
          {!! Form::label('Price') !!}
          {!! Form::number('price', null, ['class'=>'form-control', 'placeholder'=>'Price']) !!}
        </div>
        <div class="col-3">
          {!! Form::label('Commission') !!}
          {!! Form::number('commission', null, ['class'=>'form-control', 'placeholder'=>'Commission']) !!}
        </div>
        <div class="col-3">
          {!! Form::label('Date Of Sale') !!}
          {!! Form::date('date_of_sale', null, ['class'=>'form-control', 'required'=> 'required']) !!}
        </div>
        <div class="col-3">
          {!! Form::label('Date Of Completion') !!}
          {!! Form::date('date_of_completion', null, ['class'=>'form-control', 'required'=> 'required']) !!}
        </div>
      </div>
      <hr/>
      <div class="row mb-4">
        <h2 class="col-12">Additional information</h2>
        <div class="col-12 mb-3">
          {!! Form::label('Laywer Fullname') !!}
          {!! Form::text('lawyer_name', null, ['class'=>'form-control', 'placeholder'=>'Laywer Fullname']) !!}
        </div>
        <div class="col-12 mb-3">
          {!! Form::label('Payment Plan') !!}
          {!! Form::textarea('payment_terms', null, ['class'=>'form-control', 'placeholder'=>'Payment Plan', 'rows'=>2]) !!}
        </div>
        <div class="col-12 mb-3">
          {!! Form::label('Additional Note') !!}
          {!! Form::textarea('comment', null, ['class'=>'form-control', 'required'=> 'required', 'placeholder'=>'Additional Note', 'rows'=>4 ]) !!}
        </div>
      </div>


      <div class="form-group">
        {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
      </div>
    {!! Form::close() !!}
  </div>

</div>

@endsection