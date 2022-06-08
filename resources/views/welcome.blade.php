@extends('layouts.loginlayout')

@section('content')

<div id="page-container" class="main-content-boxed">

    <!-- Main Container -->
    <main id="main-container">
        <!-- Page Content -->
        <div class="bg-image js-appear-enabled animated fadeIn" data-toggle="appear" style="background-image:url('{{asset("media/photos/photo29@2x.jpg")}}')" >
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
                            <h1 class="h3 font-w700 mt-30 mb-10">Welcome to Dashboard</h1>
                            <h2 class="h5 font-w400 text-muted mb-0">Please sign in</h2>
                        </div>
                        <!-- END Header -->
                     
                        <!-- Sign In Form -->
                        <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                        <form class="js-validation-signin px-30" action="processing.php" method="post" name="login">
                            <div class="h5 font-w400 text-danger mt-10"></div>
                            <?php if(isset($_COOKIE["setcookie"])) { ?>
                                <div class="alert alert-danger">Cookie Not Set</div>
                            <?php  } ?>
                            
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                        <input type="text"  id="username" name="username" class="form-control form-control-lg" value="<?php if(isset($_COOKIE["username"])) { echo $_COOKIE["username"]; } ?>" required>
                                        <label for="login-email">Username</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                        <input type="password" id="password" name="password" class="form-control form-control-lg" value="<?php if(isset($_COOKIE["password"])) { echo $_COOKIE["password"]; } ?>" required>
                                        <label for="login-password">Password</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="login-remember-me" name="remember" value="1">
                                        <label class="custom-control-label" for="login-remember-me">Remember Me</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" name="login" value="Login" class="btn btn-sm btn-hero btn-alt-primary">
                                    <i class="si si-login mr-10"></i> Sign In
                                </button>
                                <div class="mt-30">
                                    <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="forgot-password">
                                        <i class="fa fa-warning mr-5"></i> Forgot Password
                                    </a>
                                </div>
                            </div>
                        </form>
                        <!-- END Sign In Form -->
                    </div>
                </div>
            </div>
        </div>
        <!-- END Page Content -->
    </main>
    <!-- END Main Container -->
</div>
@endsection