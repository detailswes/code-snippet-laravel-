@php
    $routeName = \Request::route()->getName();
@endphp
@php
    $loggedInUser = auth()->user();
@endphp
<div class="menu">
    <div class="main-menu">
        <div class="scroll">
            <ul class="list-unstyled">
                @if ($loggedInUser->can('dashboard_listing'))
                    <li class="{{ $routeName === 'admin.dashboard' ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="simple-icon-home"></i> Dashboard
                        </a>
                    </li>
                @endif
                @if ($loggedInUser->can('user_listing'))
                    <li class="{{ $routeName === 'users.index' ? 'active' : '' }}">
                        <a href="{{ route('users.index') }}">
                            <i class="iconsminds-conference"></i> Users
                        </a>
                    </li>
                @endif
                @if ($loggedInUser->can('roles_listing'))
                    <li class="{{ $routeName === 'roles.index' ? 'active' : '' }}">
                        <a href="{{ route('roles.index') }}">
                            <i class="iconsminds-profile"></i> Roles
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</div>
