@extends('layouts.adminlayout')
@section('content')
<div class="row mb-2">
  <div class="col-sm-6">
    <h1 class="m-0 text-dark"></h1>
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
    </ol>
  </div><!-- /.col -->
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-10">
        <h6 class="m-0 font-weight-bold text-primary">Inspections</h6>
      </div>
      <div class="col-sm-2 text-right">
      </div>
    </div>
  </div>
  <div class="card-body" id="ManageDeals">
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
      <div class="row">
        <div class="col-md-12" id="deals">
          <div class="table-responsive">
              <table class="table table-bordered users-table" id="dataTable">
                  <thead>
                      <tr>
                        <th>ID</th>
                        <th>Agent Name</th>
                        <th>Fullname</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Country</th>
                        <th>No. Of People</th>
                        <th>Busget</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
          </div>
        </div>
        </div>
      </div>
  </div>
</div>
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
        {!! Form::open(['url'=>'/admin/inspection/update', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
          <div class="form-group has-feedback">
            {!! Form::label('Comment') !!}
            {!! Form::textarea('cooment', null, ['class'=>'form-control']) !!}
            {!! Form::hidden('id', null, ['class'=>'form-control', 'id'=>'inspectionid', 'required'=> 'required']) !!}
          </div>
          <div class="form-group has-feedback">
            {!! Form::label('Status') !!}
            {!! Form::select('status', [1=>'Approved',2=>'Rejected'], '0', ['class'=>'form-control', 'required'=> 'required']) !!}
          </div>
      </div>
      <div class="modal-footer">
        {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
<script type="text/javascript">

  $(document).on('click', '#updateInspection', function (e) {
    var inspectionid = $(this).data('inspectionid');
    $('#inspectionid').val(inspectionid);
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
                    url:'{!! route('admin.inspection.data') !!}',
                    type:'post',
                    data: {
                        '_token': token
                    }
                },
                columns: 
                [
                  {
                      className: 'dt-control',
                      orderable: false,
                      data: 'id',
                      defaultContent: '',
                  },
                  { data: 'agent_name', name: 'agent_name' },
                  { data: 'fullname', name: 'fullname' },
                  { data: 'email', name: 'email' },
                  { data: 'phone_no', name: 'phone_no' },
                  { data: 'country', name: 'country' },
                  { data: 'no_of_people', name: 'no_of_people' },
                  { data: 'budget', name: 'budget' },
                  { data: 'status', name: 'status' },
                  { data: 'created_at', name: 'created_at' },
                  { data: 'update-action', name: 'action', orderable: false, searchable: false }
                ]
            });
  var detailRows = [];
  
  $('#deal-details').hide();
  $('#dataTable tbody').on('click', 'tr td.dt-control', function () {
    var data = dt.row( this ).data();
    var tr = $(this).closest('tr');
    var row = dt.row(tr);
    if (row.child.isShown()) {
        // This row is already open - close it
        row.child.hide();
        tr.removeClass('shown');
    } else {
        // Open this row
        row.child(format(row.data())).show();
        tr.addClass('shown');
    }
      
  });


  function format(d) {
    // `d` is the original data object for the row
    return (
        '<table class="table table-primary table-stripe table-condense ">' +
        '<thead><tr><th></th><th>Date</th><th>Time</th><th>Airport</th><th>Flight No.</th><th>Airline</th></tr></thead>' +
        '<tbody>'+
        '<tr><td>Arrival:</td>' +
        '<td>' + d.arrival_date + '</td><td>' + d.arrival_time + '</td><td>' + d.arrival_airport + '</td><td>' + d.arrival_flight_no + '</td><td>' + d.arrival_airline + '</td></tr>' + 
        '<tr><td>Departure:</td>' +
        '<td>' + d.departure_date + '</td><td>' + d.departure_time + '</td><td>' + d.departure_airport + '</td><td>' + d.departure_flight_no + '</td><td>' + d.departure_airline + '</td></tr>' + 
        '<tr><td>Transfer Inquiry:</td><td colspan="6">' + d.transfer_inquiry + '</td></tr>' +
        '<tr><td>Accommodation Inquiry:</td><td colspan="6">' + d.accommodation_inquiry + '</td></tr>' +
        '<tr><td>Additional Note:</td><td colspan="6">' + d.additional_note + '</td></tr>' +
        '</tbody>'+
        '</table>'
    );
}

</script>
@stop