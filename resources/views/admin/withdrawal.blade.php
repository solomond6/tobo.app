@extends('layouts.adminlayout')
@section('content')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"></h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    
  </div><!-- /.col -->
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-10">
        <h6 class="m-0 font-weight-bold text-primary">Withdrawals</h6>
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
                    url:'{!! route('withdrawal.data') !!}',
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
                  { data: 'comment', name: 'comment' },
                  { data: 'created_at', name: 'created_at' },
                  { data: 'updated_at', name: 'updated_at' },
                  { data: 'action', name: 'action', orderable: false, searchable: false }
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