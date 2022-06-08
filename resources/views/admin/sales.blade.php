@extends('layouts.adminlayout')
@section('content')
<div class="row mb-2">
  <div class="col-sm-6">
    
  </div><!-- /.col -->
  <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="{{ route('admin.sales.new') }}">Add New Deal</a></li>
      <!-- <li class="breadcrumb-item active">{{__('words.staffs')}}</li> -->
    </ol>
  </div><!-- /.col -->
</div>

<div class="card shadow mb-4">
  <div class="card-header py-3">
    <div class="row">
      <div class="col-sm-10">
        <h6 class="m-0 font-weight-bold text-primary">Deals</h6>
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
                        <th>Client Name</th>
                        <th>Property</th>
                        <th>Price</th>
                        <th>Commission</th>
                        <th>Lawyer</th>
                        <th>Date of Sale</th>
                        <th>Date of Completion</th>
                        <th>Payment Plan</th>
                        <th>Status</th>
                        <th></th>
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
<div class="modal fade" id="exampleModalDeal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update Deal Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!! Form::open(['url'=>'/admin/sales/update', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
          <div class="form-group has-feedback">
            {!! Form::label('Comment') !!}
            {!! Form::textarea('comment', null, ['class'=>'form-control']) !!}
            {!! Form::hidden('id', null, ['class'=>'form-control', 'id'=>'salesid', 'required'=> 'required']) !!}
          </div>
          <div class="form-group has-feedback">
            {!! Form::label('Status') !!}
            {!! Form::select('status', [1=>'Started',2=>'Lawyer',3=>'Payment',4=>'Registration',5=>'Ready'], '0', ['class'=>'form-control', 'required'=> 'required']) !!}
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

  $(document).on('click', '#updateStatus', function (e) {
    // e.preventDefault();
    var salesid = $(this).data('salesid');
    var agentname = $(this).data('agentname');
    $('#salesid').val(salesid);
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
                    url:'{!! route('sales.data') !!}',
                    type:'post',
                    data: {
                        '_token': token
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
                  { data: 'status', name: 'status' },
                  { data: 'update-status', name: 'action', orderable: false, searchable: false }
                ]
            });
  var detailRows = [];
  
  $('#deal-details').hide();
  // $('#dataTable tbody').on('click', 'tr', function () {
  //   var data = dt.row( this ).data();
  //   $('#agent_name').html(data['name']);
  //   $('#client_name').html(data['client_name']);
  //   $('#price').html(data['price']);
  //   $('#commission').html(data['commission']);
  //   $('#date_of_sale').html(data['date_of_sale']);
  //   $('#date_of_completion').html(data['date_of_completion']);
  //   $('#payment_terms').html(data['payment_terms']);
  //   $("#ManageDeals").find("#deals").addClass("col-md-8").removeClass("col-md-12");
  //   // $("#deals").removeClass("col-md-10").addClass("col-md-6");
  //   $('#deal-details').show();
      
      
  // });


  function format ( d ) {
    return '<strong>Tel:</strong> '+d.phone_no+'';
  }


</script>
@stop