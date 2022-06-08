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
                    <h1>Reset Password Reset</h1>
                    

                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">

                            <div class="col-md-12">
                                <label for="email">{{ __('E-Mail Address') }}</label>
                                <input id="email" type="email" class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control form-control-solid placeholder-no-fix form-group" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>
@endsection
