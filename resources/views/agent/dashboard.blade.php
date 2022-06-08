@extends('layouts.agentlayoutVue')
@section('content')

<h3>Dashboard</h3>

<div class="row">
    
    <!-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        @if($commisionDeistribution->upline_2_full_name == null)
                            <div class="h4 font-weight-bold text-primary text-uppercase mb-1">
                                {{ $commisionDeistribution->full_name  }}</div>
                                <span class="small">Sales Commision</span><br/>
                            <hr/>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">{{ number_format($sales_comm * $commisionDeistribution->commission/100, 2) }} </div>
                        @else
                            <div class="h4 font-weight-bold text-primary text-uppercase mb-1">
                                {{ $commisionDeistribution->full_name  }}</div>
                                <span class="small">Sales Commision</span><br/>
                            <hr/>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">{{ number_format( (($sales_comm * $commisionDeistribution->commission/100) *0.8), 2) }} </div>
                        @endif
                        
                    </div>

                </div>
            </div>
        </div>
    </div> -->

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h6 font-weight-bold text-primary text-uppercase mb-1">
                            Balance</div>
                        <hr/>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">{{$user_balance->amount}}</div>
                        <div class="float-left">
                            Pending Withdrawal - {{$pending_withdrawal}}
                        </div>
                        <div class="float-right">
                            @if($user_balance->amount > 0)
                                <button type="button" class="btn btn-dark btn-sm" id="updateCommission" data-toggle="modal" data-target="#exampleModal">Withdraw</button>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="h6 font-weight-bold text-primary text-uppercase mb-1">
                          Credit</div>
                      <hr/>
                      <div class="h4 mb-0 font-weight-bold text-gray-800">{{$user_balance->credit}}</div>
                  </div>

              </div>
          </div>
      </div>
  </div>
  
      <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                  <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                          <div class="h6 font-weight-bold text-primary text-uppercase mb-1">
                              Own Sales</div>
                          <hr/>
                          <div class="h4 mb-0 font-weight-bold text-gray-800">{{$own_sales}}</div>
                      </div>

                  </div>
              </div>
          </div>
      </div>
      <div class="col-xl-3 col-md-6 mb-4">
          <div class="card border-left-primary shadow h-100 py-2">
              <div class="card-body">
                  <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                          <div class="h6 font-weight-bold text-primary text-uppercase mb-1">
                              Recruit sales</div>
                          <hr/>
                          <div class="h4 mb-0 font-weight-bold text-gray-800">{{$recuit_sales}}</div>
                      </div>

                  </div>
              </div>
          </div>
      </div>
    <!-- Earnings (Monthly) Card Example --> 
</div>

<div class="row">
    <div class="col-md-8 overflow-auto pl-0 pr-0">
        <App></App>
    </div>
    <div class="col-md-4 pt-4">
        <div class="card border-right-primary shadow h-100 py-0">
            <div class="card-body">
                <img src='{{asset("media/photos/photo29.png")}}' class="img" style="width: 100%">
            </div>
        </div>
    </div>
</div>

<!-- <div class="row">
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h4 font-weight-bold text-primary text-uppercase mb-1">
                            Upline 1</div>
                            @if($commisionDeistribution->upline_2_full_name == null)
                                <div class="h4 font-weight-bold text-primary text-uppercase mb-1">
                                    {{ $commisionDeistribution->upline_0_full_name  }}</div>
                                    <span class="small">Upline 1 Commision</span><br/>
                                <hr/>
                                <div class="h2 mb-0 font-weight-bold text-gray-800">{{ number_format( ($sales_comm * $commisionDeistribution->upline_0_commission/100), 2) }} </div>
                            @else
                                <div class="h4 font-weight-bold text-primary text-uppercase mb-1">
                                    {{ $commisionDeistribution->upline_0_full_name  }}</div>
                                    <span class="small">Upline 1 Commision</span><br/>
                                <hr/>
                                <div class="h2 mb-0 font-weight-bold text-gray-800">{{ number_format( (($sales_comm * $commisionDeistribution->upline_0_commission/100) *0.8), 2) }} </div>
                            @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if($commisionDeistribution->upline_1_full_name != null)
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h4 font-weight-bold text-primary text-uppercase mb-1">
                            Upline 2</div>
                        @if($commisionDeistribution->upline_2_full_name == null)
                            <div class="h4 font-weight-bold text-primary text-uppercase mb-1">
                                {{ $commisionDeistribution->upline_1_full_name  }}</div>
                                <span class="small">Upline 2 Commision</span><br/>
                            <hr/>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">{{ number_format(($sales_comm * $commisionDeistribution->upline_1_commission/100) , 2) }}</div>
                        @else
                            <div class="h4 font-weight-bold text-primary text-uppercase mb-1">
                                {{ $commisionDeistribution->upline_0_full_name  }}</div>
                                <span class="small">Upline 2 Commision</span><br/>
                            <hr/>
                            <div class="h2 mb-0 font-weight-bold text-gray-800">{{ number_format( (($sales_comm * $commisionDeistribution->upline_1_commission/100) *0.8), 2) }} </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif
    @if($commisionDeistribution->upline_2_full_name != null)
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="h4 font-weight-bold text-primary text-uppercase mb-1">
                            Upline 3</div>
                        <div class="h4 font-weight-bold text-primary text-uppercase mb-1">
                        {{ $commisionDeistribution->upline_2_full_name  }}</div>
                        <span class="small">Upline 3 Commision</span><br/>
                        <hr/>
                        <div class="h2 mb-0 font-weight-bold text-gray-800">{{ number_format( (($sales_comm * $commisionDeistribution->commission/100) *0.2) + (($sales_comm * $commisionDeistribution->upline_0_commission/100) * 0.2) + (($sales_comm * $commisionDeistribution->upline_1_commission/100) *0.2) , 2) }}</div>
                    </div>

                </div>
            </div>
        </div>
        @endif
    </div>
    <!-- Earnings (Monthly) Card Example --> 
<!--</div> -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        {!! Form::open(['url'=>'/agent/withdrawal', 'class'=>'form']) !!}
          <div class="form-group has-feedback">
            {!! Form::label('Amount') !!}
            {!! Form::number('amount', null, ['class'=>'form-control', 'required'=> 'required', 'min'=>'0', 'max'=> floor($user_balance->amount)]) !!}
          </div>
          <div class="form-group has-feedback">
            {!! Form::label('Comment') !!}
            {!! Form::textarea('comment', null, ['class'=>'form-control']) !!}
          </div>
          <button type="submit" class="btn btn-primary btn-block btn-flat">Submit</button>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection