@extends('layouts.loginlayout')

@section('content')

<div id="page-container" class="main-content-boxed">

    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div class="bg-image js-appear-enabled animated fadeIn" data-toggle="appear" style="background-image:url('{{asset("media/photos/photo29.png")}}')" >
            <div class="row mx-0 bg-black-op">
                <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                    <div class="p-30 invisible" data-toggle="appear">
                        <p class="font-size-h3 font-w600 text-white">
                            “Making your business easier to run.”
                        </p>
                        <p class="font-italic text-white-op">
                            <a class="text-warning" href="https://www.win.center/" target="_blank">Tobo Software and Investments Ltd.</a> Copyright &copy; <span class="js-year-copy"></span>
                        </p>
                    </div>
                </div>
                <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white" data-toggle="appear" data-class="animated fadeInRight">
                    <div class="content content-full">
                        <!-- Header -->
                        <div class="px-30 py-10">
                            <img src='{{ asset("media/logo/logo-blue-m.png") }}' class="logo" style="width: 40%;"></img>
                            <h1 class="h3 font-w700 mt-30 mb-10">Don’t worry,</h1>
                            <h2 class="h5 font-w400 text-muted mb-0">we’ve got your back...</h2>
                        </div>
                        <!-- END Header -->
                     
                        <!-- Sign In Form -->
                        <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <form class="js-validation-signin px-30" method="POST" action="{{ route('forgotPassword') }}">
                           @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    @if (session('status'))
                                        <div class="alert alert-success">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    <div class="form-material form-material-primary floating">
                                        
                                        <input id="email" type="email" class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" placeholder="Username" required autofocus autocomplete="off" autocomplete="false">
                                        <!-- <label>Username </label> -->
                                        @if ($errors->has('email'))
                                               <span class="alert alert-danger invalid-feedback" role="alert" style="display: inline-flex;">
                                                   <strong>{{ $errors->first('email') }}</strong>
                                               </span>
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="login" value="Login" class="btn btn-sm btn-hero btn-alt-primary">
                                    <i class="fa fa-key mr-10"></i> Submit
                                </button>
                                <div class="mt-30">
                                    <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="{{ route('/') }}">
                                        <i class="fa fa-sign-in-alt mr-5"></i> Sign In
                                    </a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
</div>
@endsection
