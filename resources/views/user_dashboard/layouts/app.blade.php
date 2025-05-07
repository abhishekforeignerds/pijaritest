<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>{{ env('APP_NAME') }}</title>
        <meta name="keywords" content="Genial" />
        <meta name="description" content="Genial" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="{{ asset('user_dashboard/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('user_dashboard/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
        <link rel="stylesheet" href="{{asset('user_dashboard/css/daterangepicker.css')}}">
        <link rel="stylesheet" href="{{asset('backend/css/bootstrap-4.min.css')}}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <link rel="stylesheet" href="{{ asset('sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    </head>

    <body class="loading " data-layout-color="light" data-leftbar-theme="dark" data-layout-mode="fluid" data-rightbar-onstart="true"  >
        @include('user_dashboard.layouts.sidebar')
        @include('user_dashboard.layouts.header')
        @yield('content')
        @include('user_dashboard.layouts.footer')
        @yield('script')
    </body>

</html>
