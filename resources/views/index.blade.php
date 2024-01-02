<!DOCTYPE html>
<html lang="en">

<head>
    <title> Nadine</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset("assets/images/favicon.ico")}}" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset("/css/app.css")}}">

    <link rel="stylesheet" href="{{asset("assets/css/style.css")}}">

    <link rel="stylesheet" href="{{asset("assets/css/layout-rtl.css")}}">


</head>
<body>
<div id="app">
    <the-container></the-container>
</div>
{{--<script src="{{asset("assets/js/vendor-all.min.js")}}"></script>--}}
{{-- <script src="{{asset("/js/app.js")}}"></script> --}}
@vite('resources/js/app.js')

<script src="{{asset("assets/js/plugins/bootstrap.min.js")}}"></script>
{{--<script src="{{asset("assets/js/ripple.js")}}"></script>--}}
{{--<script src="{{asset("assets/js/pcoded.min.js")}}"></script>--}}
{{--<script src="{{asset("assets/js/menu-setting.min.js")}}"></script>--}}
{{--<!-- Apex Chart -->--}}
{{--<script src="{{asset("assets/js/plugins/apexcharts.min.js")}}"></script>--}}



<!-- custom-chart js -->
{{--<script src="{{asset("assets/js/pages/dashboard-analytics.js")}}"></script>--}}
</body>

</html>
