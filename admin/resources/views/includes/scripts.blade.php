<!-- jQuery -->
<script src="{{asset('asset/plugins/jquery/jquery.min.js')}}"></script>

<!-- Bootstrap 4 -->
<script src="{{asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('asset/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('asset/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Sweetalert2 -->
<script src="{{asset('asset/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- jquery-validation -->
<script src="{{asset('asset/plugins/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('asset/plugins/jquery-validation/additional-methods.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('asset/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<!-- AdminLTE App -->
<script src="{{asset('asset/js/adminlte.js')}}"></script>

<!-- Sweetalert 2 config -->
<script type="text/javascript">
    $(function() {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });

        @if(Session::has('success'))
        Toast.fire({
            icon: 'success',
            title: `{{Session::get('success')}}`
        })
        @elseif(Session::has('warning'))
        Toast.fire({
            icon: 'warning',
            title: `{{Session::get('warning')}}`
        })
        @elseif(Session::has('error'))
        Toast.fire({
            icon: 'error',
            title: `{{Session::get('error')}}`
        })
        @elseif(Session::has('info'))
        Toast.fire({
            icon: 'info',
            title: `{{Session::get('info')}}`
        })
        @endif
    });
</script>

<!-- Custom File Input -->
<script type="text/javascript">
    $('input[type="file"]').change(function(e) {
        var fileName = e.target.files[0].name;
        $('.custom-file-label').html(fileName);
    });
</script>
