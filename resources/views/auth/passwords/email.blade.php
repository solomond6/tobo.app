@extends('layouts.loginlayout')

@section('content')
<body class=" login">
    <!-- BEGIN : LOGIN PAGE 5-1 -->
    <div class="user-login-5">
        <div class="row bs-reset">
            <div class="col-md-6 bs-reset">
                <div class="login-bg" style="background-image:url(/img/login/bg1.jpg)">
                    <!-- <img class="login-logo" src="/img/login/logo.png" /> -->
                </div>
            </div>
            <div class="col-md-6 login-container bs-reset">
                <div class="login-content">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('warning'))
                        <div class="alert alert-danger">
                            {{ session('warning') }}
                        </div>
                    @endif
                    <h1>Forgot Password</h1>
                    

                    <form method="POST" action="{{ route('password.email') }}" class="login-form">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="alert alert-danger invalid-feedback" role="alert" style="display: inline-flex;">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">
                                <div class="forgot-password">
                                    <a class="forget-password" href="{{ route('login') }}">
                                        {{ __('Back To Login') }}
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-8 text-right">
                                <button class="btn btn-primary" type="submit">{{ __('Send Password Reset Link') }}</button>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
@endsection
