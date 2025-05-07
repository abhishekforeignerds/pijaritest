  <header>
      <div class="topbar d-flex align-items-center">
          <nav class="navbar navbar-expand gap-2">
              <div class="toggle-icon"><i class='bx bx-menu'></i>
              </div>
              {{-- <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
              </div> --}}
              <div class="d-none d-lg-flex align-items-center">
                <div class="clock me-2">
                    <i class="bx bx-calendar-check"></i>
                </div>

                <div class="display-date">
                    <span id="day">{{ date('l') }}</span>,
                    <span id="daynum">{{ date('d') }}</span>
                    <span id="month">{{ date('F') }}</span>
                    <span id="year">{{ date('Y') }}</span>
                </div>
                <div class="clock">
                    <i class="bx bx-stopwatch"></i>
                </div>
                <div class="display-time">{{ date('H:i:s A') }}</div>
            </div>
              <div class="top-menu ms-auto">
                  <ul class="navbar-nav align-items-center gap-1">
                      <li class="nav-item mobile-search-icon d-flex d-lg-none" data-bs-toggle="modal"
                          data-bs-target="#SearchModal">
                          <a class="nav-link" href="avascript:;"><i class='bx bx-search'></i>
                          </a>
                      </li>
                      {{-- <li class="nav-item dark-mode d-none d-sm-flex">
								<a class="nav-link dark-mode-icon" href="javascript:;"  onclick="change_theme()">@if (session()->get('theme_mode') == 'light-theme')<i class='bx bx-moon'></i>@endif @if (session()->get('theme_mode') == 'dark-theme')<i class='bx bx-sun'></i>@endif
								</a>
							</li> --}}
                      <li class="nav-item dropdown dropdown-app">
                          <div class="dropdown-menu dropdown-menu-end p-0">
                              <div class="app-container p-2 my-2">
                              </div>
                          </div>
                      </li>

                      <li class="nav-item dropdown dropdown-large">
                          <div class="dropdown-menu dropdown-menu-end">
                              <div class="header-notifications-list">
                              </div>
                          </div>
                      </li>
                      <li class="nav-item dropdown dropdown-large">
                          <div class="dropdown-menu dropdown-menu-end">
                              <div class="header-message-list">
                              </div>
                          </div>
                      </li>
                  </ul>
              </div>

              <div class="user-box dropdown">
                  <a class="d-flex align-items-center nav-link dropdown-toggle gap-2 dropdown-toggle-nocaret"
                      href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <img src="{{ asset('backend/images/avatars/admin.png') }}" class="user-img" alt="user avatar">
                      <div class="user-info">
                          <p class="user-name mb-0">Admin</p>
                      </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                      <li>
                          <a class="dropdown-item d-flex align-items-center"
                              @if (Auth::guard('admin')->check()) href="{{ route('admin_logout') }}" @endif><i
                                  class="bx bx-log-out-circle"></i><span>Logout</span></a>
                      </li>
                  </ul>
              </div>
          </nav>
      </div>
  </header>
