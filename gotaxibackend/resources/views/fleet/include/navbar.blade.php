<aside class="main-sidebar" style="background: #ffffff;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ Setting::get('site_logo', asset('')) }}" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{ Setting::get('site_title', '') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('fleet.dashboard') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item" style="margin-top: 10px;">
                    <a class="nav-link">
                        <i class="nav-icon"></i>
                        <p>User Type</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-taxi"></i>
                        <p>
                            Driver
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('fleet.provider.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Drivers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('fleet.provider.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item" style="margin-top: 10px;">
                    <a class="nav-link">
                        <i class="nav-icon"></i>
                        <p>General</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fleet.provider.review') }}" class="nav-link">
                        <i class="nav-icon fas fa-window-restore"></i>
                        <p> Reviews</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fleet.map.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-eye"></i>
                        <p> City View</p>
                    </a>
                </li>
                <li class="nav-item" style="margin-top: 10px;">
                    <a class="nav-link">
                        <i class="nav-icon"></i>
                        <p>History</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fleet.requests.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Past History</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fleet.requests.scheduled') }}" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>Upcoming Orders</p>
                    </a>
                </li>


                <li class="nav-item" style="margin-top: 10px;">
                    <a class="nav-link">
                        <i class="nav-icon"></i>
                        <p>Account</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fleet.profile') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Account Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('fleet.password') }}" class="nav-link">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>Change Passowrd</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/fleet/logout') }}" class="nav-link"
                       onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>Logout</p>
                    </a>
                </li>
                <form id="logout-form" action="{{ url('/fleet/logout') }}" method="POST" style="display: none;">

                    {{ csrf_field() }}

                </form>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>