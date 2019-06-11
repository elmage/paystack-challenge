
<!-- BEGIN VENDOR JS-->
<script src="{{ asset('js/vendors.min.js') }}" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->

<!-- BEGIN PAGE VENDOR JS-->
@yield('vendor_scripts')
<!-- END PAGE VENDOR JS-->

<!-- BEGIN CORE  JS-->
<script src="{{ asset('js/plugins.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/custom/custom-script.js') }}" type="text/javascript"></script>
<!-- END Core  JS-->

<!-- BEGIN PAGE LEVEL JS-->
@yield('page_scripts')
<script src="{{ asset('js/sweetalert.min.js') }}" type="text/javascript"></script>

{{--<script src="/js/scripts/intro.js" type="text/javascript"></script>--}}

@if(session('error'))
    <script>
        swal({
            title: "Error!",
            text: "{{session('error')}}",
            type: "error",
            confirmButtonColor: "#047bf8",
            allowOutsideClick: true,
            confirmButtonText: "OK"
        });
    </script>
@endif

@if(session('response'))
    <script>
        swal({
            title: "Info!",
            text: "{{session('response')}}",
            type: "info",
            confirmButtonColor: "#047bf8",
            allowOutsideClick: true,
            confirmButtonText: "OK"
        });
    </script>
@endif

@if(session('info'))
    <script>
        swal({
            title: "Info!",
            text: "{{session('info')}}",
            type: "info",
            confirmButtonColor: "#047bf8",
            allowOutsideClick: true,
            confirmButtonText: "OK"
        });
    </script>
@endif

@if(session('success'))
    <script>
        swal({
            title: "Success!",
            text: "{{session('success')}}",
            type: "success",
            confirmButtonColor: "#047bf8",
            allowOutsideClick: true,
            confirmButtonText: "OK"
        });
    </script>
@endif

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

<!-- END PAGE LEVEL JS-->
