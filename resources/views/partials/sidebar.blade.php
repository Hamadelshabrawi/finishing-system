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

            @can('dashboard')
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/') }}">
                <i class="fa-solid fa-gauge"></i>
                    <span class="ml-3 item-text">{{ __('messages.sidebar.dashboard') }}</span>
                </a>
            </li>
            @endcan

            @can('Roles List')
            <li class="nav-item dropdown">
                <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link">
                    <i class="fa-brands fa-critical-role"></i>
                    <span class="ml-3 item-text">{{ __('messages.sidebar.manage_roles') }}</span>
                </a>
                <ul class="dropdown-menu">
                    @can('Create Role')
                    <li class="nav-item">
                        <a class="dropdown-item" href="{{ route('roles.create') }}">
                            <i class="fas fa-plus-circle"></i> {{ __('messages.sidebar.create_role') }}
                        </a>
                    </li>
                    @endcan
                    <li class="nav-item">
                        <a class="dropdown-item" href="{{ route('roles.index') }}">
                            <i class="fas fa-list"></i> {{ __('messages.sidebar.view_roles') }}
                        </a>
                    </li>
                </ul>
            
                @can('Manage Translations')
                <li class="nav-item" style="display:none">
                    <a class="nav-link" href="{{ route('translations.index') }}">
                        <i class="fas fa-language"></i>
                        <p>{{ __('messages.translations.title') }}</p>
                    </a>
                </li>
                @endcan
            </li>
            @endcan

            @can('Permission List')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('permissions.index') }}">
                <i class="fa-solid fa-universal-access"></i>
                    <span class="ml-3 item-text">{{ __('messages.sidebar.manage_permissions') }}</span>
                </a>
            </li>
            @endcan

            @can('user list')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('users.index') }}">
                    <i class="fe fe-users"></i>
                    <span class="ml-3 item-text">{{ __('messages.sidebar.users') }}</span>
                </a>
            </li>
            @endcan

            @can('Projects List')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('projects.index') }}">
                    <i class="fas fa-project-diagram"></i>
                    <span class="ml-3 item-text">{{ __('messages.sidebar.projects') }}</span>
                </a>
            </li>
            @endcan

            @can('Clients List')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('clients.index') }}">
                    <i class="fas fa-users"></i>
                    <span class="ml-3 item-text">{{ __('messages.sidebar.clients') }}</span>
                </a>
            </li>
            @endcan

            @can('Tasks List')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('my-tasks') }}">
                    <i class="fa-solid fa-list-check"></i>
                    <span class="ml-3 item-text">@if(Auth::user()->user_type == 'Admin') {{ __('messages.sidebar.all_tasks') }} @else {{ __('messages.sidebar.my_tasks') }} @endif</span>
                </a>
            </li>
            @endcan

            @can('Items List')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('items.index') }}">
                    <i class="fas fa-cube"></i>
                    <span class="ml-3 item-text">{{ __('messages.sidebar.items') }}</span>
                </a>
            </li>
            @endcan

            @can('Suppliers List')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('suppliers.index') }}">
                    <i class="fa-solid fa-truck"></i>
                    <span class="ml-3 item-text">{{ __('messages.sidebar.suppliers') }}</span>
                </a>
            </li>
            @endcan

            @can('send_email')
            <li class="nav-item">
                <a class="nav-link" href="{{ route('email.form') }}">
                    <i class="fa-regular fa-envelope"></i>
                    <span class="ml-3 item-text">{{ __('Send Email') }}</span>
                </a>
            </li>
            @endcan
        </ul>

    </nav>
</aside>
