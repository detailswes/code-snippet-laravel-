@php
$routeName = \Request::route()->getName();
$loginUser = Auth()->user();
@endphp
<nav class="navbar fixed-top">
    <div class="d-flex align-items-center navbar-left" id="logo-container">
        <a class="navbar-logo" href="{{ route('admin.dashboard') }}">
            <span class="logo d-none d-xs-block"
                style="background-image: url('{{ getSiteLogo() }}');background-repeat:no-repeat;"></span>
            <span class="logo-mobile d-block d-xs-none"></span>

            {{-- background: url(../img/logo.png) no-repeat; --}}
            {{-- background-image: url(../img/logo.png);background-repeat:no-repeat; --}}
        </a>

        <a href="#" class="menu-button d-none d-md-block">
            <svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
                <rect x="0.48" y="0.5" width="7" height="1" />
                <rect x="0.48" y="7.5" width="7" height="1" />
                <rect x="0.48" y="15.5" width="7" height="1" />
            </svg>
            <svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
                <rect x="1.56" y="0.5" width="16" height="1" />
                <rect x="1.56" y="7.5" width="16" height="1" />
                <rect x="1.56" y="15.5" width="16" height="1" />
            </svg>
        </a>

        <a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
                <rect x="0.5" y="0.5" width="25" height="1" />
                <rect x="0.5" y="7.5" width="25" height="1" />
                <rect x="0.5" y="15.5" width="25" height="1" />
            </svg>
        </a>
    </div>

    <div class="navbar-right">
        <div class="user d-inline-block">
            <button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <span class="name usernametochange" id="full-user-name">
                    {{ $loginUser->full_name }}
                </span>
                <span>
                    <img alt="Profile Picture" src="{{ $loginUser->fullProfileImagePath() }}" id="profile_image" />
                </span>
            </button>

            <div class="dropdown-menu dropdown-menu-right mt-3">
                <a class="dropdown-item {{ $routeName === 'admin.account' ? 'nav-dropdown-item-active' : '' }}"
                    href={{ route('admin.account') }}>
                    Account
                </a>
                <form action="{{ route('logout') }}" method="post" class="dropdown-item">
                    @csrf
                    <button class="btn btn-link p-0" type="submit">Sign out</button>
                </form>
            </div>
        </div>
    </div>
</nav>
