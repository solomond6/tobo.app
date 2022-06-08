<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Pawn Show') }}</title>
    @laravelPWA
    <!-- Scripts -->
    <link href=" {{ asset('css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/print.min.css') }}" rel="stylesheet">

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery.easing.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/select2.full.min.js') }}"></script>
    <script src="{{ asset('js/print.min.js') }}"></script>
</head>
<body id="page-top">
    <div id="wrapper">
      <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
        <!-- Sidebar - Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/userhome') }}">
            <div class="sidebar-brand-icon rotate-n-15">
                <i class="fas fa-laugh-wink"></i>
            </div>
            <div class="sidebar-brand-text mx-3">{{ config('app.name', 'Pawn Shop') }}</div>
        </a>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">

        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="{{ url('/userhome') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{__('words.dashboard')}}</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <li class="nav-item">
            <a href="{{ route('staff.categories') }}" class="nav-link">
              <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{__('words.categories')}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('staff.products') }}" class="nav-link">
              <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{__('words.products')}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('staff.pawns') }}" class="nav-link ">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{__('words.pawn')}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('staff.services') }}" class="nav-link ">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{__('words.technical_services')}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('staff.technicalorders') }}" class="nav-link ">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{__('words.technical_orders')}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('staff.orders') }}" class="nav-link ">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{__('words.sales')}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('staff.buyproduct.new') }}" class="nav-link ">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>{{__('words.buy')}} {{__('words.products')}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('staff.customers') }}" class="nav-link ">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{__('words.customers')}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('staff.customers.enquiries') }}" class="nav-link ">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>{{__('words.customer_enquiries')}}</span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('staff.report') }}" class="nav-link ">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Daily Report</span>
            </a>
        </li>
      </ul>

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">
           <!-- Main Content -->
            <div id="content" class="bg-white">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <a href="{{ URL::previous() }}" class="btn btn-dark btn-sm">Back</a>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow mx-1">
                            <a class="nav-link" href="{{ route('staff.stock') }}" id="alertsDropdown">
                                <i class="fas fa-bell fa-fw fa-2x"></i>
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter text-lg">Stock Count</span>
                            </a>
                        </li>
                        @if(Session::has('pendingServicesCount'))
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell fa-fw fa-2x"></i>
                                    <!-- Counter - Alerts -->
                                    <span class="badge badge-danger badge-counter text-lg">{{ Session::get('pendingServicesCount')}}</span>
                                </a>
                                <!-- Dropdown - Alerts -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Alerts Center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('staff.service.pending') }}">
                                        <div>
                                            <div class="h4">{{ Session::get('pendingServicesCount')}} Pending Repairs</div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                </div>
                            </li>
                        @endif
                        

                        <div class="topbar-divider d-none d-sm-block"></div>
                        @if(Session::has('pawnDueTodayCount'))
                            <li class="nav-item dropdown no-arrow mx-1">
                                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-bell fa-fw fa-2x"></i>
                                    <!-- Counter - Alerts -->
                                    <span class="badge badge-danger badge-counter text-lg">{{ Session::get('pawnDueTodayCount')}}</span>
                                </a>
                                <!-- Dropdown - Alerts -->
                                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                                    <h6 class="dropdown-header">
                                        Alerts Center
                                    </h6>
                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('pawn.staff.notification') }}">
                                        <div>
                                            <div class="h4">{{ Session::get('pawnDueTodayCount')}} Pawns</div>
                                            <span class="font-weight-bold">Will be due tomorrow</span>
                                        </div>
                                    </a>
                                    <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                                </div>
                            </li>
                        @endif
                        

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                <i class="fas fa-user fa-2x"></i>
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" type="button" data-toggle="modal" data-target="#exampleModal">
                                    <i class="fas fa-change-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ url('/logout') }}" >
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                                <i class="fas fa-language fa-2x"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="/lang/en" class="btn btn-primary btn-sm">EN</a>
                                <a class="dropdown-item" href="/lang/tr" class="btn btn-primary btn-sm">TR</a>
                            </div>
                        </li>
                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                  @yield('content')  

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          {!! Form::open(['url'=>'/change/passowrd', 'class'=>'form', 'enctype'=>'multipart/form-data']) !!}
          <div class="modal-body">
              <div class="form-group has-feedback">
                {!! Form::label('New Password') !!}
                {!! Form::text('new_password', null, ['class'=>'form-control', 'required'=> 'required', 'autocomplete'=>'off']) !!}
              </div>
              <div class="form-group has-feedback">
                {!! Form::label('Confirm New Password') !!}
                {!! Form::text('new_confirm_password', null, ['class'=>'form-control', 'required'=> 'required', 'autocomplete'=>'off']) !!}
              </div>
          </div>
          <div class="modal-footer">
            {!! Form::submit('Submit', ['class'=>'btn btn-primary btn-block btn-flat']) !!}
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
    <!-- End of Modal -->    
  </body>
  <script src="{{ asset('js/sb-admin-2.min.js') }}"></script>
</html>
