<div class="site-sidebar" style="background: #152329;">

    <div class="custom-scroll custom-scroll-light">
     
        <ul class="sidebar-menu">
            
           
           

            <li>

                <a href="{{ route('admin.dashboard') }}" class="waves-effect waves-light">

                    <span class="s-icon"><i class="ti-anchor"></i></span>

                    <span class="s-text">Dashboard</span>

                </a>

            </li>

            <li>

                <a href="{{ route('admin.dispatcher.index') }}" class="waves-effect waves-light">

                    <span class="s-icon"><i class="ti-target"></i></span>

                    <span class="s-text">Dispatcher Panel</span>

                </a>

            </li>


            <li>

                <a href="{{ route('admin.heatmap') }}" class="waves-effect waves-light">

                    <span class="s-icon"><i class="ti-map"></i></span>

                    <span class="s-text">Eagle Eye</span>

                </a>

            </li>

            <li>

                <a href="{{ route('admin.push.index') }}" class="waves-effect waves-light">
                    <span class="s-icon"><img src="{{  asset('asset/img/push_notification.png') }}" alt=""
                                              style="width: 16px; height: 16px;"></span>

                    <span class="s-text">Push Notifications</span>

                </a>

            </li>


            <li class="menu-title">Roles</li>

            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-crown"></i></span>

                    <span class="s-text">Users</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.user.index') }}">List Users</a></li>

                    <li><a href="{{ route('admin.user.create') }}">Add New User</a></li>

                </ul>

            </li>

            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-car"></i></span>

                    <span class="s-text">Drivers</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.provider.index') }}">List Drivers</a></li>

                    <li><a href="{{ route('admin.provider.create') }}">Add New Driver</a></li>

                </ul>

            </li>

            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-crown"></i></span>

                    <span class="s-text">Dispatcher</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.dispatch-manager.index') }}">List Dispatcher</a></li>

                    <li><a href="{{ route('admin.dispatch-manager.create') }}">Add New Dispatcher</a></li>

                </ul>

            </li>

            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-crown"></i></span>

                    <span class="s-text">Account Manager</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.account-manager.index') }}">List Account Manager</a></li>

                    <li><a href="{{ route('admin.account-manager.create') }}">Add New Account Manager</a></li>

                </ul>

            </li>

            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-crown"></i></span>

                    <span class="s-text">Fleet Owner</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.fleet.index') }}">List Fleets</a></li>

                    <li><a href="{{ route('admin.fleet.create') }}">Add New Fleet Owner</a></li>

                </ul>

            </li>


            <li class="menu-title">Accounts</li>

            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-crown"></i></span>

                    <span class="s-text">Statements</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.ride.statement') }}">Overall Job Statments</a></li>

                    <li><a href="{{ route('admin.ride.statement.provider') }}">Driver Statement</a></li>

                    <li><a href="{{ route('admin.ride.statement.today') }}">Daily Statement</a></li>

                    <li><a href="{{ route('admin.ride.statement.monthly') }}">Monthly Statement</a></li>

                    <li><a href="{{ route('admin.ride.statement.yearly') }}">Yearly Statement</a></li>

                </ul>

            </li>


            <li class="menu-title">Reviews</li>

            <li>

            <li><a href="{{ route('admin.user.review') }}" class="waves-effect waves-light">

                    <span class="s-icon"><i class="ti-view-grid"></i></span>

                    <span class="s-text">User Reviews</span>

                </a>
            </li>
            <li>
                <a href="{{ route('admin.provider.review') }}" class="waves-effect waves-light">

                    <span class="s-icon"><i class="ti-view-grid"></i></span>

                    <span class="s-text">Driver Reviews</span>

                </a>
            </li>


            </li>

            <li class="menu-title">Details</li>

            <li>

                <a href="{{ route('admin.map.index') }}" class="waves-effect waves-light">

                    <span class="s-icon"><i class="ti-map-alt"></i></span>

                    <span class="s-text">Map</span>

                </a>

            </li>


            <li class="menu-title">History</li>

            <li>

                <a href="{{ route('admin.requests.index') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="ti-infinite"></i></span>

                    <span class="s-text">Request History</span>

                </a>

            </li>

            <li>

                <a href="{{ route('admin.requests.scheduled') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="ti-palette"></i></span>

                    <span class="s-text">Scheduled Rides</span>

                </a>

            </li>

            <li>

                <a href="{{ route('admin.promocode.usage') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="ti-infinite"></i></span>

                    <span class="s-text">Promocode Usage</span>

                </a>

            </li>

            <li class="menu-title">Services</li>

            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-view-grid"></i></span>

                    <span class="s-text">Service Types</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.service.index') }}">List Service Types</a></li>

                    <li><a href="{{ route('admin.service.create') }}">Add New Service Type</a></li>

                </ul>

            </li>

            <!-- <li class="with-sub">

				<a href="#" class="waves-effect  waves-light">

					<span class="s-caret"><i class="fa fa-angle-down"></i></span>

					<span class="s-icon"><i class="ti-view-grid"></i></span>

					<span class="s-text">Service Price Pckages</span>

				</a>

				<ul>

					<li><a href="{{ route('admin.package.index') }}">List Packages</a></li>

					<li><a href="{{ route('admin.package.create') }}">Add New Package</a></li>

				</ul>

			</li> -->

            <li class="menu-title">General</li>


            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-layout-tab"></i></span>

                    <span class="s-text">Documents</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.document.index') }}">List Documents</a></li>

                    <li><a href="{{ route('admin.document.create') }}">Add New Document</a></li>

                </ul>

            </li>


            <li class="with-sub">

                <a href="#" class="waves-effect  waves-light">

                    <span class="s-caret"><i class="fa fa-angle-down"></i></span>

                    <span class="s-icon"><i class="ti-layout-tab"></i></span>

                    <span class="s-text">Promocodes</span>

                </a>

                <ul>

                    <li><a href="{{ route('admin.promocode.index') }}">List Promocodes</a></li>

                    <li><a href="{{ route('admin.promocode.create') }}">Add New Promocode</a></li>

                </ul>

            </li>


            <li class="menu-title">Payment Details</li>

            <li>

                <a href="{{ route('admin.payment') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="ti-infinite"></i></span>

                    <span class="s-text">Payment History</span>

                </a>

            </li>

            <li>

                <a href="{{ route('admin.settings.payment') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="ti-money"></i></span>

                    <span class="s-text">Payment Settings</span>

                </a>

            </li>

            <li class="menu-title">Settings</li>

            <li>

                <a href="{{ route('admin.settings') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="ti-settings"></i></span>

                    <span class="s-text">Site Settings</span>

                </a>

            </li>

            <li>

                <a href="{{ route('admin.settings.appsetting') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="ti-settings"></i></span>

                    <span class="s-text">Application Settings</span>

                </a>

            </li>


            <li class="menu-title">Others</li>

            <li>

                <a href="{{ route('admin.privacy') }}" class="waves-effect waves-light">

                    <span class="s-icon"><i class="ti-help"></i></span>

                    <span class="s-text">Privacy Policy</span>

                </a>

            </li>

            <li>

                <a href="{{ route('admin.terms') }}" class="waves-effect waves-light">

                    <span class="s-icon"><i class="ti-help"></i></span>

                    <span class="s-text">Terms & Conditions</span>

                </a>

            </li>

            <!--
			<li>

				<a href="{{route('admin.translation') }}" class="waves-effect waves-light">

					<span class="s-icon"><i class="ti-smallcap"></i></span>

					<span class="s-text">Translations</span>

				</a>

			</li> -->

            <li class="menu-title">Account</li>

            <li>

                <a href="{{ route('admin.profile') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="ti-user"></i></span>

                    <span class="s-text">Account Settings</span>

                </a>

            </li>

            <li>

                <a href="{{ route('admin.password') }}" class="waves-effect  waves-light">

                    <span class="s-icon"><i class="ti-exchange-vertical"></i></span>

                    <span class="s-text">Change Password</span>

                </a>

            </li>

            <li class="compact-hide">

                <a href="{{ url('/admin/logout') }}"

                   onclick="event.preventDefault();

                                     document.getElementById('logout-form').submit();">

                    <span class="s-icon"><i class="ti-power-off"></i></span>

                    <span class="s-text">Logout</span>

                </a>


                <form id="logout-form" action="{{ url('/admin/logout') }}" method="POST" style="display: none;">

                    {{ csrf_field() }}

                </form>

            </li>


        </ul>

    </div>

</div>

