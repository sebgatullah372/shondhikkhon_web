<!DOCTYPE html>
<html>
@include('auth-includes.head')

<body class="hold-transition login-page">
<div class="login-box">
    @yield('content')
</div>
<!-- /.login-box -->
</body>
@include('auth-includes.scripts')
</html>
