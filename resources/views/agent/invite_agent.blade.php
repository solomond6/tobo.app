@extends('layouts.agentlayout')
@section('content')

<div class="row">
  <div class="col-md-8">
    <div class="card mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark">Downlines</h6>
      </div>
      <div class="card-body">
        <ul style="list-style: none;">
            @foreach ($downlines as $ref)
                <li>
                    <a class="btn btn-light w-100 mt-1 mb-1 text-start text-uppercase" data-bs-toggle="collapse" href="#multiCollapseExample1" role="button" aria-expanded="false" aria-controls="multiCollapseExample1">{{ $ref['username'] }}</a>
                    <ul style="list-style: none;">
                        @foreach ($ref['downline'] as $children)
                            <div class="collapse multi-collapse" id="multiCollapseExample1">
                                <li>
                                    <a class="btn btn-light w-100 mt-1 mb-1 text-start" data-bs-toggle="collapse" href="#multiCollapseExample2" role="button" aria-expanded="false" aria-controls="multiCollapseExample2">{{ $children['username'] }}</a>
                                </li>
                            </div>
                            <ul style="list-style: none;">
                                @foreach ($children['downline'] as $grandchildren)
                                    <div class="collapse multi-collapse" id="multiCollapseExample2">
                                        <li>
                                            <a class="btn btn-light w-100 mt-1 mb-1 text-start" data-bs-toggle="collapse" href="#multiCollapseExample3" role="button" aria-expanded="false" aria-controls="multiCollapseExample3">{{ $grandchildren['username'] }}</a>
                                        </li>
                                    </div>
                                    <ul style="list-style: none;">
                                        @foreach ($grandchildren['downline'] as $sgrandchildren)                            
                                            <div class="collapse multi-collapse" id="multiCollapseExample3">
                                                <li>
                                                  <a class="btn btn-light w-100 mt-1 mb-1 text-start">{{ $sgrandchildren['username'] }}</a>
                                                </li>
                                            </div>
                                        @endforeach
                                    </ul>
                                @endforeach
                            </ul>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card mb-4">
      <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-dark">Agent Invitation</h6>
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
          {!! Form::open(['url'=>'/agent/sendinvite', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
            <div class="form-group has-feedback">
              {!! Form::label('Email') !!}
              {!! Form::text('agent_email', null, ['class'=>'form-control', 'required'=> 'required']) !!}
            </div>
            <div class="form-group">
              {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
            </div>
          {!! Form::close() !!}
      </div>
    </div>
  </div>
</div>


@endsection