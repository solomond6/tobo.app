<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name', 'Tobo App') }}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Welcome to Tobo! - Login</title>

        <meta name="description" content="Tobo - Login created by Tobo Software Ltd.">
        <meta name="author" content="tobo">
        <meta name="robots" content="noindex, nofollow">

        <!-- Open Graph Meta -->
        <meta property="og:title" content="Tobo - Login">
        <meta property="og:site_name" content="Tobo">
        <meta property="og:description" content="Tobo - Login created by Tobo Software Ltd.">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">
        

        <link rel="preload" as="image" href="{{ asset('media/photos/photo29@2x.jpg') }} ">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href=" {{ asset('media/favicons/favicon-192x192.png') }} ">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }} ">

        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700&display=swap">
        <link rel="stylesheet" id="css-main" href="{{ asset('css/codebase.min.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('css/codebase.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ asset('css/all.css') }}">

    </head>
    <body class="bg-gradient-primary">
    @yield('content')
    </body>
    <script src="{{ asset('js/codebase.core.min.js') }}"></script>
    <script src="{{ asset('js/codebase.app.min.js') }}"></script>
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/op_auth_signin.min.js') }}"></script>
</html>