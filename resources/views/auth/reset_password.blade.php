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
                            <h1 class="h3 font-w700 mt-30 mb-10">Set New Password</h1>
                            <h2 class="h5 font-w400 text-muted mb-0"></h2>
                        </div>
                        <!-- END Header -->
                     
                        <!-- Sign In Form -->
                        <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <form action="{{ route('reset.password.post') }}" method="POST" class="js-validation-signin px-30">
                            @csrf
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                        <input type="text" id="email_address" class="form-control" name="email" value="{{ $email }}" placeholder="Email Address" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                        <input type="password" id="password" class="form-control" name="password" placeholder="New Password" required autofocus>
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                        <input type="password" id="password-confirm" class="form-control" name="password_confirmation" placeholder="Confirm New Password" required autofocus>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                          Reset Password
                                    </button>
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
