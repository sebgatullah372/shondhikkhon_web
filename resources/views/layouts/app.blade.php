<!DOCTYPE html>
<html>
@include('includes.head')
@stack('push-style')
<body>
<div class="site-wrap">

    @include('includes.site_mobile_menu')
    @include('includes.header')

    <div>
        @yield('content')
    </div>

    @include('includes.footer')

</div>
<!-- ./wrapper -->
@include('includes.scripts')
@stack('push-script')
</body>
</html>
