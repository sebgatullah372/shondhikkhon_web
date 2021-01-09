<!DOCTYPE html>
<html>
@include('includes.head')
@stack('push-style')
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

@include('includes.navbar')

@include('includes.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    @include('includes.footer')

</div>
<!-- ./wrapper -->
@include('includes.scripts')
@stack('push-script')
</body>
</html>
