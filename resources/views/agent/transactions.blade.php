@extends('layouts.agentlayout')
@section('content')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Transactions</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <!-- <li class="breadcrumb-item active">{{__('words.staffs')}}</li> -->
    </ol>
  </div><!-- /.col -->
</div>

<div class="row">
  <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
              <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                      <div class="h6 font-weight-bold text-primary text-uppercase mb-1">
                          Balance</div>
                      <hr/>
                      <div class="h4 mb-0 font-weight-bold text-gray-800">{{$user_balance->amount}}</div>
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
</div>



<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-10">
        <h6 class="m-0 font-weight-bold text-primary">Inflow</h6>
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
      <div class="table-responsive">
          <table class="table table-bordered users-table" id="dataTable">
              <thead>
                  <tr>
                    <th>No.</th>
                    <th>TransactionID</th>
                    <th>Agent Commission</th>
                    <th>WIN Service Fee</th>
                    <th>Income</th>
                    <th>Comment</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
      </div>
  </div>
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-10">
        <h6 class="m-0 font-weight-bold text-primary">Withdrawal</h6>
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

      <div class="table-responsive">
          <table class="table table-bordered withdrawal-table" id="wDataTable">
              <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Comment</th>
                    <th>Date Created</th>
                    <th>Date Updated</th>
                    <th></th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
      </div>
  </div>
</div>

<script type="text/javascript">

  $(document).on('click', '#updateCommission', function (e) {
    // e.preventDefault();
    var agentid = $(this).data('agentid');
    var agentname = $(this).data('agentname');
    $('#agentid').val(agentid);
    $('.agentname').html(agentname);
  });

  //var template = Handlebars.compile($("#details-template").html());
  $(function() {
    
  });
  var token = '{{ csrf_token() }}';

  var dt = $('.users-table').DataTable({
              processing: true,
              serverSide: true,
              responsive: true,
                ajax: {
                    url:'{!! route('agent.transactions.data') !!}',
                    type:'post',
                    data: {
                        '_token': token
                    }
                },
                columns: 
                [
                  {"data": "sn",
                    render: function (data, type, row, meta) {
                      return meta.row + meta.settings._iDisplayStart + 1;
                    }
                  },
                  { data: 'id', name: 'id' , orderable: false, searchable: false},
                  { data: 'commission', name: 'commission' , orderable: false, searchable: false},
                  { data: 'service_charge', name: 'service_charge' , orderable: false, searchable: false},                  
                  { data: 'amount', name: 'amount' , orderable: false, searchable: false},
                  { data: 'comment', name: 'comment' , orderable: false, searchable: false },
                  // { data: 'set-commission', name: 'action', orderable: false, searchable: false }
                ],
                'columnDefs': [
                  {
                      "targets": 0,
                      "className": "text-center",
                  },
                  {
                      "targets": 1,
                      "className": "text-right",
                  },
                  {
                      "targets": 2,
                      "className": "text-right",
                  },
                  {
                      "targets": 3,
                      "className": "text-right",
                  },
                  {
                      "targets": 4,
                      "className": "text-right",
                  },{
                      "targets": 5,
                      "className": "text-left",
                  }
                ],
            });
  var detailRows = [];
 
  $(document).on('click', '#switchBranchBtn', function (e) {
    e.preventDefault();
    var userid = $(this).data('userid');
    $('#userList').val(userid);
  });

  var token2 = '{{ csrf_token() }}';

  var dtw = $('.withdrawal-table').DataTable({
              processing: true,
              serverSide: true,
              responsive: true,
                ajax: {
                    url:'{!! route('agent.withdrawal.data') !!}',
                    type:'post',
                    data: {
                        '_token': token2
                    }
                },
                columns: 
                [
                  { data: 'id', name: 'id' },
                  { data: 'name', name: 'name' },
                  { data: 'amount', name: 'amount' },
                  { data: 'comment', name: 'comment' },
                  { data: 'created_at', name: 'created_at' },
                  { data: 'updated_at', name: 'updated_at' },
                  { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });

  function format ( d ) {
    return '<strong>Tel:</strong> '+d.phone_no+'';
  }

</script>
@stop