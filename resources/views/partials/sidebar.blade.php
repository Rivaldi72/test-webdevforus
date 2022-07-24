<!-- HEADER MOBILE-->
<header class="header-mobile d-block d-lg-none">
    <div class="header-mobile__bar">
        <div class="container-fluid">
            <div class="header-mobile-inner">
                <a href="#">
                    <div class="d-flex justify-content-between">
                        <h2>WebDevForus</h2>
                    </div>
                </a>
                <button class="hamburger hamburger--slider" type="button">
                    <span class="hamburger-box ">
                        <span class="hamburger-inner fa fa-align-justify text-success"></span>
                    </span>
                </button>
            </div>
        </div>
    </div>
    <nav class="navbar-mobile">
        <div class="container-fluid">
            <ul class="navbar-mobile__list list-unstyled">
                <li class="{{ (request()->is('/')) ? 'active' : '' }}">
                    <a href="{{route('dashboard')}} ">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>
                @can('isAdmin')
                <li class="{{ (request()->is('user*')) ? 'active' : '' }}">
                    <a href="{{route('user.index')}}">
                        <i class="fas fa-user"></i>Data User
                    </a>
                </li>
                <li class="{{ (request()->is('group*')) ? 'active' : '' }}">
                    <a href="{{route('group.index')}}">
                        <i class="fas fa-link"></i>Data Group
                    </a>
                </li>
                @endcan
                @canany(['isAdmin', 'isOperator'])
                <li class="{{ (request()->is('member*')) ? 'active' : '' }}">
                    <a href="{{ route('member.index') }}" class="">
                        <i class="fas fa-users"></i>Data Member
                    </a>
                </li>
                @endcanany
                <li class="{{ (request()->is('about')) ? 'active' : '' }}">
                    <a href="#" onclick="logout()">
                        <i class="fas fa-power-off"></i>Log Out</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<!-- END HEADER MOBILE-->

<!-- MENU SIDEBAR-->
<aside class="menu-sidebar d-none d-lg-block">
    <div class="logo">
        <a href="#">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="text-light">WebDevForus</h2>
            </div>
        </a>
    </div>
    <div class="menu-sidebar__content js-scrollbar1">
        <nav class="navbar-sidebar">
            <ul class="list-unstyled navbar__list">
                <li class="{{ (request()->is('/')) ? 'active' : '' }}">
                    <a href="{{route('dashboard')}} ">
                        <i class="fas fa-tachometer-alt"></i>Dashboard</a>
                </li>
                @can('isAdmin')
                <li class="{{ (request()->is('user*')) ? 'active' : '' }}">
                    <a href="{{route('user.index')}}">
                        <i class="fas fa-user"></i>Data User
                    </a>
                </li>
                <li class="{{ (request()->is('group*')) ? 'active' : '' }}">
                    <a href="{{route('group.index')}}">
                        <i class="fas fa-link"></i>Data Group
                    </a>
                </li>
                
                @endcan
                @canany(['isAdmin', 'isOperator'])
                <li class="{{ (request()->is('member*')) ? 'active' : '' }}">
                    <a href="{{ route('member.index') }}" class="">
                        <i class="fas fa-users"></i>Data Member
                    </a>
                </li>
                
                @endcanany
                <li class="{{ (request()->is('about')) ? 'active' : '' }}">
                    <a href="#" onclick="logout()">
                        <i class="fas fa-power-off"></i>Log Out</a>
                </li>
            </ul>
        </nav>
    </div>
</aside>
<!-- END MENU SIDEBAR-->