@extends('layouts.adminlayout')
@section('content')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Agent Details</h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <!-- <li class="breadcrumb-item active">{{__('words.staffs')}}</li> -->
    </ol>
  </div><!-- /.col -->
</div>

<div class="row">
  <div class="col-md-3">
    <div class="card card-primary card-outline">
      
      <div class="card-body box-profile">
        <div class="text-center">
          @if($agentDetails->agent_pic == null)
            <i class="fas fa-user-alt fa-5x mr-3"></i>
            <h3 class="profile-username text-center">{{ $agentDetails->first_name }} {{ $agentDetails->last_name }}</h3>
            {!! Form::open(['url'=>'/admin/upload-agent-pic', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
            <div class="form-group">
                <div class="input-group">
                  <div class="custom-file">
                    <input type="hidden" name="agent_id" value="{{ $agentDetails->id }}" required>
                    <input type="file" name="image" class="custom-file-input" id="exampleInputFile" required>
                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                  </div>
                  <div class="input-group-append">
                    <button class="input-group-text" type="submit">Upload</button>
                  </div>
              </div>
              {!! Form::close() !!}
            </div>
          @else
            <img class="profile-user-img img-fluid img-circle" src="{{ asset('/agent_images/'.$agentDetails->agent_pic) }}" alt="User profile picture">
            <h3 class="profile-username text-center">{{ $agentDetails->first_name }} {{ $agentDetails->last_name }}</h3>
          @endif
        </div>
        
        <ul class="list-group list-group-unbordered mb-3">
          <li class="list-group-item">
            <b>Balance</b> <a class="float-right">{{ number_format($agentDetails->user_balance, 2) }}</a>
          </li>
        </ul>
        <strong><i class="fas fa-mails mr-1"></i> </strong>
        <p class="text-muted">
         {{ $agentDetails->email }}
        </p>
        <hr>
        <strong><i class="fas fa-phone-alt mr-1"></i> </strong>
        <p class="text-muted">
         {{ $agentDetails->phone_no }}
        </p>
      </div>
    </div>
  </div>
  <div class="col-md-9">
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3>Sales</h3>
      </div>
      <div class="card-body box-profile">
        <div class="table-responsive">
            <table class="table table-bordered users-table" id="dataTable">
                <thead>
                    <tr>
                      <th>ID</th>
                      <th>Agent Name</th>
                      <th>Client Name</th>
                      <th>Property</th>
                      <th>Price</th>
                      <th>Commission</th>
                      <th>Lawyer</th>
                      <th>Date of Sale</th>
                      <th>Date of Completion</th>
                      <th>Payment Plan</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card card-primary card-outline">
      <div class="card-header">
        <h3>Transactions</h3>
      </div>
      <div class="card-body box-profile">
        <div class="table-responsive">
          <table class="table table-bordered transaction-table" id="dataTable">
              <thead>
                  <tr>
                    <th>ID</th>
                    <th>Agent Name</th>
                    <th>Commission</th>
                    <th>Service Charge</th>
                    <th>Income</th>
                    <th>Comment</th>
                    <th>Date</th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
      </div>
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

  var agent_id = '{{ $agentDetails->id }}';

  var token = '{{ csrf_token() }}';

  var dt = $('.users-table').DataTable({
              processing: true,
              serverSide: true,
              responsive: true,
                ajax: {
                    url:'{!! route('sales.agentdata') !!}',
                    type:'post',
                    data: {
                        '_token': token,
                        'agent_id': agent_id
                    }
                },
                columns: 
                [
                  { data: 'id', name: 'id' },
                  { data: 'name', name: 'name' },
                  { data: 'client_name', name: 'client_name' },
                  { data: 'property_id', name: 'property_id' },
                  { data: 'price', name: 'price' },
                  { data: 'commission', name: 'commission' },
                  { data: 'lawyer_name', name: 'lawyer_name' },
                  { data: 'date_of_sale', name: 'date_of_sale' },
                  { data: 'date_of_completion', name: 'date_of_completion' },
                  { data: 'payment_terms', name: 'payment_terms' },
                  // { data: 'set-commission', name: 'action', orderable: false, searchable: false }
                ]
            });
  var detailRows = [];
 
  var tokentransaction = '{{ csrf_token() }}';

  var dt = $('.transaction-table').DataTable({
              processing: true,
              serverSide: true,
              responsive: true,
                ajax: {
                    url:'{!! route('transactions.agentdata') !!}',
                    type:'post',
                    data: {
                        '_token': tokentransaction,
                        'agent_id': agent_id
                    }
                },
                columns: 
                [
                  { data: 'id', name: 'id' },
                  { data: 'name', name: 'name' },
                  { data: 'commission', name: 'commission' },
                  { data: 'service_charge', name: 'service_charge' },                  
                  { data: 'amount', name: 'amount' },
                  { data: 'comment', name: 'comment' },
                  { data: 'created_at', name: 'created_at' },
                  // { data: 'set-commission', name: 'action', orderable: false, searchable: false }
                ]
            });
  $(document).on('click', '#switchBranchBtn', function (e) {
    e.preventDefault();
    var userid = $(this).data('userid');
    $('#userList').val(userid);
  });


  function format ( d ) {
    return '<strong>Tel:</strong> '+d.phone_no+'';
  }

</script>
@stop