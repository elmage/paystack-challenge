<!-- BEGIN: Header-->
<header class="page-topbar" id="header">
    <div class="navbar navbar-fixed">
        <nav class="navbar-main navbar-color nav-collapsible sideNav-lock navbar-dark gradient-45deg-indigo-purple no-shadow">
            <div class="nav-wrapper">

                <ul class="navbar-list right">
                    <li>
                        <a class="waves-effect waves-block waves-light" href="javascript:void(0);">
                            <i class="material-icons">account_balance_wallet</i>
                            <span style="margin-bottom: 5px;">{{ balance() }}</span>
                        </a>
                    </li>
                    <li class="hide-on-med-and-down"><a class="waves-effect waves-block waves-light toggle-fullscreen" href="javascript:void(0);"><i class="material-icons">settings_overscan</i></a></li>
                    <li>
                        <a class="waves-effect waves-block waves-light profile-button" href="javascript:void(0);" data-target="profile-dropdown">
                            <span class="avatar-status avatar-online">
                                <img src="https://www.gravatar.com/avatar/?d=mm&s=50" alt="avatar"><i></i>
                            </span>
                        </a>
                    </li>
                </ul>
                <!-- profile-dropdown-->
                <ul class="dropdown-content" id="profile-dropdown">
                    <li><a class="grey-text text-darken-1" href="{{ route('settings') }}"><i class="material-icons">person_outline</i> Profile</a></li>
                    <li class="divider"></li>
                    <li><a type="submit" href="#!" onclick="document.getElementById('global-logout').submit()" class="grey-text text-darken-1"><i class="material-icons">keyboard_tab</i> Logout</a></li>
                </ul>

                <form action="{{ url('/logout') }}" method="post" id="global-logout">
                    @csrf
                </form>
            </div>
        </nav>
    </div>
</header>
<!-- END: Header-->