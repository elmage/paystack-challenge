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
        <li class="bold{{ !empty($all_suppliers) || !empty($create_supplier) ? ' active open':'' }}">
            <a class="collapsible-header waves-effect waves-cyan" href="#">
                <i class="material-icons">account_box</i><span class="menu-title" data-i18n="">Manage Suppliers</span>
            </a>

            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    <li class="{{ !empty($all_suppliers) ? 'active':'' }}">
                        <a class="collapsible-body{{ !empty($all_suppliers) ? ' active':'' }}" href="{{ route('suppliers') }}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>All Suppliers</span></a>
                    </li>
                    <li class="{{ !empty($create_supplier) ? 'active':'' }}">
                        <a class="collapsible-body{{ !empty($create_supplier) ? ' active':'' }}" href="{{ route('supplier.create') }}" data-i18n=""><i class="material-icons">radio_button_unchecked</i><span>Add Supplier</span></a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="bold{{ isset($transfers) || isset($single_transfer) ? ' active open':'' }}">
            <a class="collapsible-header waves-effect waves-cyan" href="#">
                <i class="material-icons">account_balance</i><span class="menu-title" data-i18n="">Send Money</span>
            </a>

            <div class="collapsible-body">
                <ul class="collapsible collapsible-sub" data-collapsible="accordion">
                    <li class="{{ isset($transfers) ? 'active':'' }}">
                        <a class="collapsible-body{{ isset($transfers) ? ' active':'' }}" href="{{ route('transfers') }}" data-i18n="">
                            <i class="material-icons">radio_button_unchecked</i>
                            <span>Transfers</span>
                        </a>
                    </li>
                    <li class="{{ isset($single_transfer) ? 'active':'' }}">
                        <a class="collapsible-body{{ isset($single_transfer) ? ' active':'' }}" href="{{ route('transfer.single') }}" data-i18n="">
                            <i class="material-icons">radio_button_unchecked</i>
                            <span>Single Transfer</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="bold{{ isset($settings)  ? ' active open':'' }}">
            <a class="waves-effect waves-cyan{{ isset($settings)  ? ' active open':'' }}" href="{{ route('settings') }}">
                <i class="material-icons">settings</i>
                <span class="menu-title" data-i18n="">Settings</span>
            </a>
        </li>
    </ul>
    <div class="navigation-background"></div>
    <a class="sidenav-trigger btn-sidenav-toggle btn-floating btn-medium waves-effect waves-light hide-on-large-only" href="#" data-target="slide-out"><i class="material-icons">menu</i></a>
</aside>
<!-- END: SideNav-->