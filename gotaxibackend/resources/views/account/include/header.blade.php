<!-- Header -->
<div class="site-header">
    <nav class="navbar navbar-light" style="display: block;">
        <div class="navbar-left">
            <a class="navbar-brand" href="{{url('account/dashboard')}}">
                <div class="logo"
                     style="background: url({{ Setting::get('site_logo', asset('logo-black.png')) }}) no-repeat;"></div>
            </a>
            <div class="toggle-button dark sidebar-toggle-first float-xs-left hidden-md-up">
                <span class="hamburger"></span>
            </div>
            <div class="toggle-button-second dark float-xs-right hidden-md-up">
                <i class="ti-arrow-left"></i>
            </div>
            <div class="toggle-button dark float-xs-right hidden-md-up" data-toggle="collapse"
                 data-target="#collapse-1">
                <span class="more"></span>
            </div>
        </div>
        <div class="navbar-right navbar-toggleable-sm collapse" id="collapse-1" style="float: right;">
            <div class="toggle-button light sidebar-toggle-second float-xs-left hidden-sm-down">
                <span class="hamburger"></span>
            </div>

            <ul class="nav navbar-nav" style="flex-direction: row !important;">
                <li class="nav-item hidden-sm-down">
                    <a class="nav-link toggle-fullscreen" href="#">
                        <i class="ti-fullscreen"></i>
                    </a>
                </li>

                <li class="nav-item dropdown hidden-sm-down">
                    <a href="#" data-toggle="dropdown" aria-expanded="false">
						<span class="avatar box-32">
							<img src="{{img(Auth::guard('admin')->user()->picture)}}" alt="">
						</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right animated fadeInUp">
                        <a class="dropdown-item" href="{{route('account.profile')}}">
                            <i class="ti-user mr-0-5"></i> Profile
                        </a>
                        <a class="dropdown-item" href="{{route('account.password')}}">
                            <i class="ti-settings mr-0-5"></i> Change Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ url('/account/logout') }}"
                           onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();"><i
                                    class="ti-power-off mr-0-5"></i> Sign out</a>
                    </div>
                </li>
            </ul>

        </div>
    </nav>
</div>