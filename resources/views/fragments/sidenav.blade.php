<!-- BEGIN: SideNav-->
<aside class="sidenav-main nav-expanded nav-lock nav-collapsible sidenav-light sidenav-active-square">
    <div class="brand-sidebar">
        <h1 class="logo-wrapper">
            <a class="brand-logo darken-1" href="{{ route('home') }}">
                <img src="{{ asset('images/logo/logo.png') }}" alt=" logo"/>
                <span class="logo-text hide-on-med-and-down">Materialize</span>
            </a>
            <a class="navbar-toggler" href="#"><i class="material-icons">radio_button_checked</i></a></h1>
    </div>
    <ul class="sidenav sidenav-collapsible leftside-navigation collapsible sidenav-fixed menu-shadow" id="slide-out" data-menu="menu-navigation" data-collapsible="menu-accordion">

        <li class="bold">
            <a class="waves-effect waves-cyan{{ !empty($home) ? ' active':'' }}" href="{{ route('home') }}">
                <i class="material-icons">settings_input_svideo</i>
                <span class="menu-title" data-i18n="">Dashboard</span>
            </a>
        </li>

        <li class="navigation-header"><a class="navigation-header-text">Applications</a><i class="navigation-header-icon material-icons">more_horiz</i>
        </li>
        <li class="bold{{ !empty($suppliers) || !empty($create_supplier) ? ' active open':'' }}">
            <a class="collapsible-header waves-effect waves-cyan" href="#">
                <i class="material-icons">account_box</i><span class="menu-title" data-i18n="">Manage Suppliers</span>
            </a>

            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    <li class="{{ !empty($suppliers) ? 'active':'' }}">
                        <a class="collapsible-body{{ !empty($suppliers) ? ' active':'' }}" href="{{ route('suppliers') }}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Suppliers</span></a>
                    </li>
                    <li class="{{ !empty($create_supplier) ? 'active':'' }}">
                        <a class="collapsible-body{{ !empty($create_supplier) ? ' active':'' }}" href="{{ route('supplier.create') }}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Supplier</span></a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="bold">
            <a class="waves-effect waves-cyan " href="app-email.html">
                <i class="material-icons">mail_outline</i>
                <span class="menu-title" data-i18n="">Mail</span>
                <span class="badge new badge pill pink accent-2 float-right mr-10">5</span>
            </a>
        </li>

    </ul>
    <div class="navigation-background"></div>
    <a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>
<!-- END: SideNav-->