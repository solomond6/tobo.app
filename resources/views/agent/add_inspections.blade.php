@extends('layouts.agentlayout')
@section('content')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"></h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="/agent/inspections">Inspections</a></li>
    </ol>
  </div><!-- /.col -->
</div>

<div class="card shadow mb-4 col-12">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-10">
        <h6 class="m-0 font-weight-bold text-primary">New Inspection</h6>
      </div>
      <div class="col-sm-2 text-right">
        
      </div>
    </div>
  </div>
  <div class="card-body text-dark">
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
      {!! Form::open(['url'=>'/agent/inspections/new', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
  
      <div class="row mb-4">
        <h4 class="col-12">Contact information</h4>
        <div class="col-3">
          {!! Form::label('Name') !!}
          {!! Form::text('fullname', null, ['class'=>'form-control', 'placeholder'=>'Enter Client Fullname']) !!}
        </div>
        <div class="col-4">
          {!! Form::label('Email') !!}
          {!! Form::text('email', null, ['class'=>'form-control', 'placeholder'=>'Enter Client Email']) !!}
        </div>
        <div class="col-5">
          {!! Form::label('Phone Number') !!}
          {!! Form::text('phone_no', null, ['class'=>'form-control', 'placeholder'=>'Enter Client Phone Number']) !!}
          
        </div>
      </div>
      <hr/>
      <div class="row mb-4">
        <h4 class="col-12">Trip Information</h4>
        <div class="col-4">
          {!! Form::label('Country') !!}
          {!! Form::select('country', $countries, 0, ['class'=>'form-control', 'required'=> 'required']) !!}
        </div>
        <div class="col-4">
          {!! Form::label('Number Of People') !!}
          {!! Form::number('no_of_people', null, ['class'=>'form-control', 'min'=>1, 'max'=>20, 'placeholder'=>'Number of People']) !!}
        </div>
        <div class="col-4">
          {!! Form::label('Budget') !!}
          {!! Form::number('budget', null, ['class'=>'form-control', 'min'=>1, 'max'=>1000000, 'placeholder'=>'Budget']) !!}
        </div>
      </div>
      <hr/>
      <div class="row mb-4">
        <h4 class="col-12">Flight Information</h4>
        <h6 class="col-12">Arrival</h6>
        <div class="col-2">
          {!! Form::label('Date') !!}
          {!! Form::date('arrival_date', null, ['class'=>'form-control', 'required'=> 'required']) !!}
        </div>
        <div class="col-2">
          {!! Form::label('Time') !!}
          {!! Form::time('arrival_time', null, ['class'=>'form-control', 'required'=> 'required']) !!}
        </div>
        <div class="col-3">
          {!! Form::label('Airport') !!}
          {!! Form::text('arrival_airport', null, ['class'=>'form-control', 'placeholder'=>'Airport']) !!}
        </div>
        <div class="col-2">
          {!! Form::label('Flight Number') !!}
          {!! Form::text('arrival_flight_no', null, ['class'=>'form-control', 'placeholder'=>'Flight Number']) !!}
        </div>
        <div class="col-3">
          {!! Form::label('Flight Number') !!}
          {!! Form::text('arrival_airline', null, ['class'=>'form-control', 'placeholder'=>'Airline']) !!}
        </div>
      </div>
      <hr/>
      <div class="row mb-4">
        <h6 class="col-12">Departure</h6>
        <div class="col-2">
          {!! Form::label('Date') !!}
          {!! Form::date('departure_date', null, ['class'=>'form-control']) !!}
        </div>
        <div class="col-2">
          {!! Form::label('Time') !!}
          {!! Form::time('departure_time', null, ['class'=>'form-control']) !!}
        </div>
        <div class="col-3">
          {!! Form::label('Airport') !!}
          {!! Form::text('departure_airport', null, ['class'=>'form-control', 'placeholder'=>'Airport']) !!}
        </div>
        <div class="col-2">
          {!! Form::label('Flight Number') !!}
          {!! Form::text('departure_flight_no', null, ['class'=>'form-control', 'placeholder'=>'Flight Number']) !!}
        </div>
        <div class="col-3">
          {!! Form::label('Flight Number') !!}
          {!! Form::text('departure_airline', null, ['class'=>'form-control', 'placeholder'=>'Airline']) !!}
        </div>
      </div>
      <hr/>
      <div class="row mb-4">
        <h4 class="col-12">Additional information</h4>
        <div class="col-12 mb-3">
          {!! Form::label('Transfer Inquiry') !!}
          {!! Form::textarea('transfer_inquiry', null, ['class'=>'form-control', 'placeholder'=>'Transfer Inquiry','rows'=>2]) !!}
        </div>
        <div class="col-12 mb-3">
          {!! Form::label('Accommodation Inquiry') !!}
          {!! Form::textarea('accommodation_inquiry', null, ['class'=>'form-control', 'placeholder'=>'Accommodation Inquiry', 'rows'=>2]) !!}
        </div>
        <div class="col-12 mb-3">
          {!! Form::label('Additional Note') !!}
          {!! Form::textarea('additional_note', null, ['class'=>'form-control', 'placeholder'=>'Additional Note', 'rows'=>2 ]) !!}
        </div>
      </div>


      <div class="form-group">
        {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
      </div>
    {!! Form::close() !!}
  </div>

</div>

@endsection