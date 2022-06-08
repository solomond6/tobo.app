@extends('layouts.agentlayout')
@section('content')
<div class="row mb-2">
  <div class="col-sm-6">
    
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item">
        <a href="{{ route('agent.inspections.new') }}">
            <i class="fas fa-plus"></i>
            <span>Add Inspection Trips</span></a>
        </a></li>
      <!-- <li class="breadcrumb-item active">{{__('words.staffs')}}</li> -->
    </ol>
  </div><!-- /.col -->
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-10">
        <h1 class="m-0 text-dark h4">Inspection Trips</h1>
        <!-- <h6 class="m-0 font-weight-bold text-primary"></h6> -->
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
                        <th>Budget</th>
                        <th>Status</th>
                        <th>Date</th>
                      </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
          </div>
        </div>
        <div class="col-md-4" id="deal-details">
          <div class="col-xs-12" >
            <div class="card">
              <div class="p-5 text-center" style="background:#2e72b7; color: #fff;">
                <!-- <a class="img-card" href="http://www.fostrap.com/2016/03/5-button-hover-animation-effects-css3.html"> -->
                <h5>Agent</h5>
                <h2 id="agent_name"></h2>
              </div>
              <div class="card-content p-4">
                <table class="table">
                  <tr>
                    <td>Client Name</td>
                    <td><h4 id="client_name"></h4></td>
                  </tr>
                  <tr>
                    <td>Price</td>
                    <td><h4 id="price"></h4></td>
                  </tr>
                  <tr>
                    <td>Commission</td>
                    <td><h4 id="commission"></h4></td>
                  </tr>
                  <tr>
                    <td>Date Of Sale</td>
                    <td><h4 id="date_of_sale"></h4></td>
                  </tr>
                  <tr>
                    <td>Date Of Completion</td>
                    <td><h4 id="date_of_completion"></h4></td>
                  </tr>
                  <tr>
                    <td>Payment Terms</td>
                    <td><h4 id="payment_terms"></h4></td>
                  </tr>
                </table>
              </div>
            </div>
        </div>
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
  var token = '{{ csrf_token() }}';

  var dt = $('.users-table').DataTable({
              processing: true,
              serverSide: true,
              responsive: true,
                ajax: {
                    url:'{!! route('agent.inspection.data') !!}',
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
                  // { data: 'set-commission', name: 'action', orderable: false, searchable: false }
                ]
            });
  var detailRows = [];
  
  $('#deal-details').hide();
  $('#dataTable tbody').on('click', 'tr', function () {
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
        '<tr><td>Transfer Inquiry:</td><td colspan="5">' + d.transfer_inquiry + '</td></tr>' +
        '<tr><td>Accommodation Inquiry:</td><td colspan="5">' + d.accommodation_inquiry + '</td></tr>' +
        '<tr><td>Additional Note:</td><td colspan="5">' + d.additional_note + '</td></tr>' +
        '</tbody>'+
        '</table>'
    );
}

</script>
@stop