<!DOCTYPE html>

<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="author" content="Samuel Mage">
    <title>{{ config('app.name') }} - @yield('title')</title>
    <link rel="apple-touch-icon" href="{{ asset('images/favicon/apple-touch-icon-152x152.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/favicon/favicon-32x32.png') }}">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- BEGIN: VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/vendors.min.css') }}">
    <!-- END: VENDOR CSS-->
    <!-- BEGIN: Page Level CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/materialize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/login.css') }}">
    <!-- END: Page Level CSS-->
    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/custom/custom.css') }}">
    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->
<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu 1-column login-bg  blank-page blank-page" data-open="click" data-menu="vertical-modern-menu" data-col="1-column">
<div class="row">
    <div class="col s12">
        <div class="container">
            @yield('content')
        </div>
    </div>
</div>


<script src="{{ asset('js/vendors.min.js') }}" type="text/javascript"></script>

<script src="{{ asset('js/plugins.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/custom/custom-script.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/sweetalert.min.js') }}" type="text/javascript"></script>

@if(count($errors)>0)
    <script>
        let options = {};
        options.title = 'Error!';
        options.type = 'error';
        options.text = '{{$errors->all()[0]}}';
        options.confirmButtonClass = 'btn btn-danger';
        options.confirmButtonText='Got it!';
        swal(options);
    </script>
@endif

</body>
</html>