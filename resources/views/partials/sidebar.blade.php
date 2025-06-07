<aside class="sidebar-left border-right bg-white shadow" id="leftSidebar" data-simplebar>
    <a href="#" class="btn collapseSidebar toggle-btn d-lg-none text-muted ml-2 mt-3" data-toggle="toggle">
        <i class="fe fe-x"><span class="sr-only"></span></i>
    </a>
    <nav class="vertnav navbar navbar-light">
        <!-- nav bar -->
        <div class="w-100 mb-4 d-flex">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="{{ url('/') }}">
                <img src="{{ asset('Assets/en/assets/images/logo.png') }}" class="w-50" alt="logo">
            </a>
        </div>

        <ul class="navbar-nav flex-fill w-100 mb-2">

            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">
                    <i class="fe fe-users"></i>
                    <span class="ml-3 item-text">{{ __('Dashboard') }}</span>
                </a>
            </li>
                @can('Roles List')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('roles.index') }}">
                        <i class="fe fe-lock"></i>
                        <span class="ml-3 item-text">{{ __('Manage Roles') }}</span>
                    </a>
                </li>
                @endcan
                @can('Permission List')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('permissions.index') }}">
                        <i class="fe fe-lock"></i>
                        <span class="ml-3 item-text">{{ __('Manage Permissions') }}</span>
                    </a>
                </li>
                @endcan
                
                @can('user list')
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('users.index') }}">
                        <i class="fe fe-users"></i>
                        <span class="ml-3 item-text">{{ __('Users') }}</span>
                    </a>
                </li>
                @endcan
            @can('Projects List')
            <ul class="navbar-nav flex-fill w-100 mb-2">
                <li class="nav-item dropdown">
                <a href="#dashboard" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle nav-link">
                    <i class="fe fe-file fe-16"></i>
                    <span class="ml-3 item-text">Project</span><span class="sr-only">(current)</span>
                </a>
                <ul class="collapse list-unstyled pl-4 w-100" id="dashboard">
                    @can('Create Project')
                    <li class="nav-item active">
                    <a class="nav-link pl-3" href="{{ route('projects.create') }}"><span class="ml-1 item-text">Create</span></a>
                    </li>
                    @endcan
                    @can('Projects List')
                    <li class="nav-item">
                    <a class="nav-link pl-3" href="{{ route('projects.index') }}"><span class="ml-1 item-text">Project List</span></a>
                    </li>
                    @endcan
                </ul>
                </li>
            </ul>
            @endcan

            @can('Items List')
                <li class="nav-item dropdown">
                    <a href="{{ route('items.index') }}" class="nav-link">
                        <i class="fe fe-users fe-16"></i>
                        <span class="ml-3 item-text">{{ __('Items') }}</span>
                    </a>
                </li>
            @endcan
            @can('Clients List')
                <li class="nav-item dropdown">
                    <a href="{{ route('clients.index') }}" class="nav-link">
                        <i class="fe fe-users fe-16"></i>
                        <span class="ml-3 item-text">{{ __('Clients') }}</span>
                    </a>
                </li>
            @endcan
            @can('Send Email')
                <li class="nav-item dropdown">
                    <a href="{{ route('email.form') }}" class="nav-link">
                        <i class="fe fe-users fe-16"></i>
                        <span class="ml-3 item-text">{{ __('Send Email') }}</span>
                    </a>
                </li>
            @endcan
        </ul>

    </nav>
</aside>
