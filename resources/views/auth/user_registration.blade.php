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
                <div class="signup-content">
                    
                    <h1>Signup For Benefit</h1>
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
                    <form method="POST" action="{{ route('register') }}" class="login-form">
                        @csrf
                        <div class="form-group col-md-6">
                            <input type="hidden" name="reg_type" value="userreg">
                            <label for="name">{{ __('Firstname') }}</label>
                            <input id="first_name" type="text" class="form-control form-control-solid placeholder-no-fix form-group" name="first_name" value="{{ old('first_name') }}" placeholder="First Name" required autocomplete="off" autocomplete="false"/>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="name">{{ __('Lastname') }}</label>
                            <input id="last_name" type="text" class="form-control form-control-solid placeholder-no-fix form-group" placeholder="Last Name" name="last_name" value="{{ old('last_name') }}" required autocomplete="off" autocomplete="false"/>
                        </div>

                        <div class="form-group col-md-12">
                            <label class="radio-inline">
                                <input type="radio" name="emailUse" value="1" checked required="true"> Use your company email
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="emailUse" value="2" required="true"> Use your private email
                            </label>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="email">{{ __('E-Mail Address') }}</label>
                            <input id="emailc" type="email" placeholder="Email Address" class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" autocomplete="off" autocomplete="false"/>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="privateUse">
                            <div class="form-group col-md-12">
                                <label for="company_code">{{ __('Company Code') }}</label>
                                <input id="company_code" type="text" placeholder="Company Code" class="form-control form-control-solid placeholder-no-fix form-group" name="company_code" value="{{$comSearch->company_code}}" autocomplete="off" autocomplete="false"/>
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="address">Address</label>
                            <input class="form-control form-control-solid placeholder-no-fix form-group" type="text" name="address" placeholder="Address" required="required">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="country">Country</label>
                            <select name="country_id" placeholder="Country" class="form-control form-control-solid placeholder-no-fix form-group" id="country" required="required">
                                <option value="">Select A Country</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="state">State</label>
                            <select name="state_id"  class="form-control form-control-solid placeholder-no-fix form-group" placeholder="City" id="state" required="required">
                                <option value="">Select A State</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="city">City</label>
                            <select name="city_id" class="form-control form-control-solid placeholder-no-fix form-group" placeholder="City" id="city">
                                <option value="">Select A City</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="off" autocomplete="false" placeholder="Password"/>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password-confirm">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control form-control-solid placeholder-no-fix form-group" name="password_confirmation" placeholder="Confirm Password" required autocomplete="off" autocomplete="false"/>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                            <div class="col-md-6">
                                <h4><a href="{{url('home')}}">Back To Home</a></h4>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<script>

    $('.privateUse').hide();
    $('#emailc').prop('required', true);

    $('input[name="emailUse"]').change(function(){

        var emialType = $('input[name="emailUse"]:checked').val();

        if(emialType == '1'){
            $('.privateUse').hide();
            $('#company_code').prop('required', false);                    
        }else if(emialType == '2'){
            $('.privateUse').show();
            $('#company_code').prop('required', true);
        }
    })
    

    var token = '{{ csrf_token() }}';
    $.ajax({
        type: 'GET',
        url:'{!! route('countries.data') !!}',
        data: {
          //'_token': token
        },
        success: function(data){
            $.each(data, function(i, item){
                $('#country').append($('<option>',{
                    value: item.id,
                    text: item.name,
                }));
            });
        }
    });

    $.ajax({
        type: 'GET',
        url:'{!! route('countries.data') !!}',
        data: {
          //'_token': token
        },
        success: function(data){
            $.each(data, function(i, item){
                $('#country1').append($('<option>',{
                    value: item.id,
                    text: item.name,
                }));
            });
        }
    });

    $(document).on('change', '#country', function(){
        $('#state').empty();
        $('#state').append($('<option>',{
            value: "",
            text: "Select A State",
        }));
        $.ajax({
            type: 'GET',
            url:'{!! route('getCountryStates.data') !!}',
            data: {
              //'_token': token,
              'country_id': $('#country').val()
            },
            success: function(data){
                $.each(data, function(i, item){
                    $('#state').append($('<option>',{
                        value: item.id,
                        text: item.name,
                    }));
                });
            }
        });
    });

    $(document).on('change', '#country1', function(){
        $('#state1').empty();
        $('#state1').append($('<option>',{
            value: "",
            text: "Select A State",
        }));
        $.ajax({
            type: 'GET',
            url:'{!! route('getCountryStates.data') !!}',
            data: {
              //'_token': token,
              'country_id': $('#country1').val()
            },
            success: function(data){
                $.each(data, function(i, item){
                    $('#state1').append($('<option>',{
                        value: item.id,
                        text: item.name,
                    }));
                });
            }
        });
    });

    $(document).on('change', '#state', function(){
        $('#city').empty();
        $('#city').append($('<option>',{
            value: "",
            text: "Select A City",
        }));
        $.ajax({
            type: 'GET',
            url:'{!! route('cities.data') !!}',
            data: {
              //'_token': token,
              'state_id': $('#state').val()
            },
            success: function(data){
                $.each(data, function(i, item){
                    $('#city').append($('<option>',{
                        value: item.id,
                        text: item.name,
                    }));
                });
            }
        });
    });
    $(document).on('change', '#state1', function(){
        $('#city1').empty();
        $('#city1').append($('<option>',{
            value: "",
            text: "Select A City",
        }));
        $.ajax({
            type: 'GET',
            url:'{!! route('cities.data') !!}',
            data: {
              //'_token': token,
              'state_id': $('#state1').val()
            },
            success: function(data){
                $.each(data, function(i, item){
                    $('#city1').append($('<option>',{
                        value: item.id,
                        text: item.name,
                    }));
                });
            }
        });
    });
</script>
@endsection
