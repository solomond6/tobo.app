@extends('layouts.adminlayout')
@section('content')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark">Agents</h1>
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
        <a href="{{ route('admin.inviteagent') }}" class="btn btn-primary btn-sm">
          <i class="fa fa-plus"></i>  Send Invitation
        </a>
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
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Balance</th>
                    <th>Referral</th>
                    <th></th>
                    <th></th>
                    <th></th>
                  </tr>
              </thead>
              <tbody>
              </tbody>
          </table>
      </div>
  </div>
</div>

<div class="modal left fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Set Commission For <span class="agentname"></span></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! Form::open(['url'=>'/admin/set-commission/', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
        <div class="modal-body">
            <div class="form-group has-feedback">
              {!! Form::label('Amount') !!}
              {!! Form::hidden('id', null, ['class'=>'form-control', 'id'=>'agentid']) !!}
              {!! Form::number('commission_amt', null, ['class'=>'form-control', 'id'=>'commision', 'placeholder'=>'Commission Amount', 'min'=> 1, 'required' => 'required']) !!}
            </div>
        </div>
        <div class="modal-footer">
          {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
        </div>
    </div>
  </div>
</div>

<div class="modal left fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">

        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="myModalLabel">Left Sidebar</h4>
        </div>

        <div class="modal-body">
          <p>Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
          </p>
        </div>

      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
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
                    url:'{!! route('agent.data') !!}',
                    type:'post',
                    data: {
                        '_token': token
                    }
                },
                columns: 
                [
                  { data: 'id', name: 'id' },
                  { data: 'name', name: 'name' },
                  { data: 'email', name: 'email' },
                  { data: 'phone_no', name: 'phone_no' },
                  { data: 'balance', name: 'balance' },
                  { data: 'referralname', name: 'referralname' },
                  { data: 'action', name: 'action', orderable: false, searchable: false },
                  { data: 'delete-action', name: 'action', orderable: false, searchable: false },
                  { data: 'view-details', name: 'action', orderable: false, searchable: false }
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