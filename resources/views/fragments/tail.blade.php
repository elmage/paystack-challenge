
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
<script src="{{ asset('js/scripts/dashboard-modern.js') }}" type="text/javascript"></script>
{{--<script src="/js/scripts/intro.js" type="text/javascript"></script>--}}
<!-- END PAGE LEVEL JS-->