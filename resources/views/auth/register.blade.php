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
                        <div class="px-20 py-10">
                            <img src='{{ asset("media/logo/logo-blue-m.png") }}' class="logo" style="width: 40%;"></img>
                            <h1 class="h3 font-w700 mt-30 mb-10">Registration Form</h1>
                        </div>
                        <!-- END Header -->
                     
                        <!-- Sign In Form -->
                        <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
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
                        @if (session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form class="js-validation-signin px-30" method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                        <!-- <input type="hidden" name="reg_type" value="company"> -->
                                        <!-- <label for="name">{{ __('Username') }}</label> -->
                                        <input id="first_name" type="text" placeholder="Firstname" class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}" name="first_name" value="{{ old('first_name') }}" required autocomplete="off" autocomplete="false"/>
                                        @if ($errors->has('first_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                        <!-- <input type="hidden" name="reg_type" value="company"> -->
                                        <!-- <label for="name">{{ __('Username') }}</label> -->
                                        <input id="name" type="text" placeholder="Lastname" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required autocomplete="off" autocomplete="false"/>
                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                    <!-- <label for="email">{{ __('E-Mail Address') }}</label> -->
                                    <input id="email" type="email" placeholder="Email Address" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autocomplete="off" autocomplete="false"/>
                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                    <!-- <label for="email">{{ __('E-Mail Address') }}</label> -->
                                    <input id="phone_number" type="tel" placeholder="Phone Number" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" required autocomplete="off" autocomplete="false"/>
                                    @if ($errors->has('phone_number'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('phone_number') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                    <!-- <label for="address">Address</label> -->
                                    <input class="form-control" type="text" name="address" placeholder="Address" required="required">
                                    <input class="form-control" type="hidden" name="ref" value="{{$ref}}" required="required">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                    <select name="country_id" placeholder="Country" class="form-control" id="country" required="required">
                                        <option value="">Select A Country</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                    <select name="state_id"  class="form-control" placeholder="City" id="state" required="required">
                                        <option value="">Select A State</option>
                                    </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                    <select name="city_id" class="form-control" placeholder="City" id="city">
                                        <option value="">Select A City</option>
                                    </select>
                                    </div>
                                </div>
                            </div> -->
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                    <!-- <label for="password">{{ __('Password') }}</label> -->
                                    <input id="password" type="password" placeholder="Password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required autocomplete="off" autocomplete="false" />
                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <div class="form-material form-material-primary floating">
                                    <!-- <label for="password-confirm">{{ __('Confirm Password') }}</label> -->
                                    <input id="password-confirm" placeholder="Password Confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="off" autocomplete="false"/>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
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

<script>
    $('#myTab a[href="#merchant"]').tab('show');
    $('#myTab a[href="#company"]').tab('show');

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

