<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset("assets/vendor/bootstrap/css/bootstrap.min.css") }}">
    <link href="{{ asset("assets/vendor/fonts/circular-std/style.css") }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("assets/libs/css/style.css")}}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/fonts/fontawesome/css/fontawesome-all.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/charts/chartist-bundle/chartist.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/charts/morris-bundle/morris.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/fonts/material-design-iconic-font/css/materialdesignicons.min.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/charts/c3charts/c3.css") }}">
    <link rel="stylesheet" href="{{ asset("assets/vendor/fonts/flag-icon-css/flag-icon.min.css") }}">
    <link rel="stylesheet" href="{{asset('css/loader.css') }}" />


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>


    <title>DB Automatika</title>
</head>

<body>
<!-- ============================================================== -->
<!-- main wrapper -->
<!-- ============================================================== -->
<div class="dashboard-main-wrapper">
    <!-- ============================================================== -->
    <!-- navbar -->
    <!-- ============================================================== -->
    @include('partials.navbar')
    <!-- ============================================================== -->
    <!-- end navbar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- left sidebar -->
    <!-- ============================================================== -->
    @include('partials.left_sidebar')
    <!-- ============================================================== -->
    <!-- end left sidebar -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- wrapper  -->
    <!-- ============================================================== -->
    <div class="dashboard-wrapper">
        <div class="container-fluid dashboard-content ">
        @yield('pageheader')
        @yield('content')
        @include('partials.footer')
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- end wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- end main wrapper  -->
<!-- ============================================================== -->
<!-- Optional JavaScript -->
<!-- jquery 3.3.1 -->
{{--<script src="{{ asset("assets/vendor/jquery/jquery-3.3.1.min.js") }}"></script>--}}
<!-- bootstap bundle js -->
<script src="{{ asset("assets/vendor/bootstrap/js/bootstrap.bundle.js") }}"></script>
<!-- slimscroll js -->
<script src="{{ asset("assets/vendor/slimscroll/jquery.slimscroll.js") }}"></script>
<!-- main js -->
<script src="{{ asset("assets/libs/js/main-js.js") }}"></script>
<!-- chart chartist js -->
<script src="{{ asset("assets/vendor/charts/chartist-bundle/chartist.min.js") }}"></script>
<!-- sparkline js -->
<script src="{{ asset("assets/vendor/charts/sparkline/jquery.sparkline.js") }}"></script>
<!-- morris js -->
<script src="{{ asset("assets/vendor/charts/morris-bundle/raphael.min.js") }}"></script>
<script src="{{ asset("assets/vendor/charts/morris-bundle/morris.js") }}"></script>
<!-- chart c3 js -->
<script src="{{ asset("assets/vendor/charts/c3charts/c3.min.js") }}"></script>
<script src="{{ asset("assets/vendor/charts/c3charts/d3-5.4.0.min.js") }}"></script>
<script src="{{ asset("assets/vendor/charts/c3charts/C3chartjs.js") }}"></script>
<script src="{{ asset("assets/libs/js/dashboard-ecommerce.js") }}"></script>
@yield('script')
</body>

</html>