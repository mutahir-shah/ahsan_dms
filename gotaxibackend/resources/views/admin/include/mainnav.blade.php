<aside class="main-sidebar" style="background: #ffffff;">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ Setting::get('site_logo', asset('')) }}" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">{{ Setting::get('site_title', 'Taxitime') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>{{ translateKeyword('dashboard') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.dispatcher.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>{{ translateKeyword('dispatcher') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.heatmap') }}" class="nav-link">
                        <i class="nav-icon fas fa-map"></i>
                        <p>{{ translateKeyword('Eagle Eye') }}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.push.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-bell"></i>
                        <p>Push Notifications</p>
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
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.user.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.user.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                    </ul>
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
                            <a href="{{ route('admin.provider.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Drivers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.provider.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Dispatcher
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.dispatch-manager.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Dispatchers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.dispatch-manager.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Dispatcher</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user-circle"></i>
                        <p>
                            Accountant
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.account-manager.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Account Managers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.account-manager.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Account Manager</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>
                            Fleet Group
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.fleet.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Fleets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.fleet.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Fleet</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" style="margin-top: 10px;">
                    <a class="nav-link">
                        <i class="nav-icon"></i>
                        <p>Details</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.review') }}" class="nav-link">
                        <i class="nav-icon fas fa-window-restore"></i>
                        <p> Reviews</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-crown"></i>
                        <p>
                            Statements
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.ride.statement') }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>Overall Statments</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.ride.statement.provider') }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>Driver Statement</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.ride.statement.today') }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>Daily Statement</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.ride.statement.monthly') }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>Monthly Statement</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.ride.statement.yearly') }}" class="nav-link">
                                <i class="nav-icon"></i>
                                <p>Yearly Statement</p>
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
                    <a href="{{ route('admin.map.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-eye"></i>
                        <p> Country View</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                            Documents
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.document.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Documents</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.document.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Document</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-percent"></i>
                        <p>
                            Promocodes
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.promocode.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Promo</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.promocode.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Promocode</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Services
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.service.index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Services</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.service.create') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Service</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item" style="margin-top: 10px;">
                    <a class="nav-link">
                        <i class="nav-icon"></i>
                        <p>History</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.requests.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Past History</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.requests.scheduled') }}" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>Upcoming Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.payment') }}" class="nav-link">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Payment History</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.promocode.usage') }}" class="nav-link">
                        <i class="nav-icon fas fa-plus"></i>
                        <p>Promocode History</p>
                    </a>
                </li>

                <li class="nav-item" style="margin-top: 10px;">
                    <a class="nav-link">
                        <i class="nav-icon"></i>
                        <p>Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings') }}" class="nav-link">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>Web Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.appsetting') }}" class="nav-link">
                        <i class="nav-icon fas fa-mobile-alt"></i>
                        <p>App Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.settings.payment') }}" class="nav-link">
                        <i class="nav-icon fas fa-key"></i>
                        <p>Payment Settings</p>
                    </a>
                </li>


                <li class="nav-item" style="margin-top: 10px;">
                    <a class="nav-link">
                        <i class="nav-icon"></i>
                        <p>Extra</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.privacy') }}" class="nav-link">
                        <i class="nav-icon fas fa-user-secret"></i>
                        <p>Privacy Policy</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.terms') }}" class="nav-link">
                        <i class="nav-icon fas fa-info-circle"></i>
                        <p>Terms & Conditions</p>
                    </a>
                </li>


                <li class="nav-item" style="margin-top: 10px;">
                    <a class="nav-link">
                        <i class="nav-icon"></i>
                        <p>Account</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.profile') }}" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>Account Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.password') }}" class="nav-link">
                        <i class="nav-icon fas fa-exchange-alt"></i>
                        <p>Change Passowrd</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ url('/admin/logout') }}" class="nav-link"
                       onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>Logout</p>
                    </a>
                </li>
                <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">

                    {{ csrf_field() }}

                </form>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>