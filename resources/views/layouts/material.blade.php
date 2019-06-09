<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">

@include('fragments.head')

<body class="vertical-layout vertical-menu-collapsible page-header-dark vertical-modern-menu 2-columns" data-open="click" data-menu="vertical-modern-menu" data-col="2-columns">

@include('fragments.header')

@include('fragments.sidenav')

<!-- BEGIN: Page Main-->
<div id="main">
    @yield('content')
</div>
<!-- END: Page Main-->

@include('fragments.footer')

@include('fragments.tail')

</body>
</html>