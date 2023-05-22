
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
</script>

@if (session('error'))
<script>
//toastr.options.positionClass = "toast-top-right";
toastr['error']('{{session('error')}}');

</script>
@endif
@if (session('success'))
<script>
//toastr.options.positionClass="toast-top-right";
toastr['success']('{{session('success')}}');

</script>
@endif
