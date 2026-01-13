      <nav class="topnav navbar navbar-light">
        <button type="button" class="navbar-toggler text-muted mt-2 p-0 mr-3 collapseSidebar">
          <i class="fe fe-menu navbar-toggler-icon"></i>
        </button>
        <ul class="nav">
          <li class="nav-item">
            <a class="nav-link text-muted my-2" href="#" id="modeSwitcher" data-mode="light">
              <i class="fe fe-sun fe-16"></i>
            </a>
          </li>
          
          <li class="nav-item dropdown">
              <a class="nav-link text-muted my-2 dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fe fe-globe fe-16"></i>
                  <span class="ml-1">{{ strtoupper(app()->getLocale()) }}</span>
              </a>
              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="languageDropdown">
                  <a class="dropdown-item" href="{{ route('language.switch', 'en') }}">English (EN)</a>
                  <a class="dropdown-item" href="{{ route('language.switch', 'ar') }}">العربية (AR)</a>
              </div>
          </li>
        
          <li class="nav-item nav-notif">
            <a class="nav-link text-muted my-2" href="./#" data-toggle="modal" data-target=".modal-notif">
              <span class="fe fe-bell fe-16"></span>
              <span class="dot dot-md bg-success"></span>
            </a>
          </li>
          <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-muted pr-0" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="avatar avatar-sm mt-2">
                        <img src="{{ auth()->user()->profile_image ? asset('storage/' . auth()->user()->profile_image) : asset('Assets/en/assets/avatars/face-1.jpg') }}" 
                            alt="Profile Image" class="avatar-img rounded-circle">
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="{{ route('profile.show', auth()->user()->id) }}">Profile</a>
                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        </ul>
      </nav>