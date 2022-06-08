@extends('layouts.moderatorlayout')
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

<div class="card shadow mb-4">
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
      <div class="table-responsive">
          <table class="table table-bordered users-table" id="dataTable">
              <thead>
                  <tr>
                    <th>ID</th>
                    <th>Agent Name</th>
                    <th>Amount</th>
                    <th>Type</th>
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
                    url:'{!! route('transactions.data') !!}',
                    type:'post',
                    data: {
                        '_token': token
                    }
                },
                columns: 
                [
                  { data: 'id', name: 'id' },
                  { data: 'name', name: 'name' },
                  { data: 'amount', name: 'amount' },
                  { data: 'type', name: 'type' },
                  { data: 'comment', name: 'comment' },
                  { data: 'created_at', name: 'created_at' },
                  // { data: 'set-commission', name: 'action', orderable: false, searchable: false }
                ]
            });
  var detailRows = [];
 
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