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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' ||  
                    Auth::guard('admin')->user()->type == 'admin' ||
                    Auth::guard('admin')->user()->type == 'manager')
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                           class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pie-chart"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endif
                {{-- <li class="nav-item">
                    <a href="{{ route('admin.subadmin') }}"
                        class="nav-link {{ request()->is('admin/subadmin') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-pie-chart"></i>
                        <p>Subadmin</p>
                    </a>
                </li> --}}
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' ||
                    Auth::guard('admin')->user()->type == 'customer_service' ||
                    Auth::guard('admin')->user()->type == 'manager' 
                )
                    <li class="nav-item">
                        <a href="{{ route('admin.dispatcher.index') }}"
                           class="nav-link {{ request()->is('admin/dispatcher') ? 'active' : '' }} d-flex justify-content-between align-items-center">
                           <div>
                               <i class="nav-icon fas fa-th"></i>
                               <p>Dispatcher</p>
                           </div>
                           <span id="dispatcher-trips-count" class="badge {{ request()->is('admin/dispatcher') ? 'badge-light' : 'badge-danger' }}">0</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.booking-requests-web') }}"
                           class="nav-link {{ request()->is('admin/booking-requests-web') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-car"></i>
                            <p> Booking Requests Form</p>
                            <span id="booking-requests-forms-count" class="badge {{ request()->is('admin/booking-requests-web') ? 'badge-light' : 'badge-danger' }}">0</span>
                        </a>
                    </li>
                    <script>
                        window.onload = () => {
                        const dispatcherTripsCount = document.querySelector('#dispatcher-trips-count');
                        const dispatcherUsersCount = document.querySelector('#dispatcher-users-count');
                        const dispatcherProvidersCount = document.querySelector('#dispatcher-providers-count');
                        const bookingRequestsFormCount = document.querySelector('#booking-requests-forms-count');
                        const contactEnquiriesCount = document.querySelector('#contact-enquiries-count');
                        const bell = document.createElement('audio');
                        bell.src = '/asset/audio/bell.wav';
                        @if(request()->is('admin/user'))
                            fetch("{{ route('admin.dispatcher.mark_users_as_viewed') }}")
                            dispatcherUsersCount.innerText = 0;
                        @elseif(request()->is('admin/provider'))
                            fetch("{{ route('admin.dispatcher.mark_providers_as_viewed') }}")
                            dispatcherUsersCount.innerText = 0;
                        @elseif(request()->is('admin/booking-requests-web'))
                            fetch("{{ route('admin.dispatcher.mark_booking_requests_as_viewed') }}")
                            bookingRequestsFormCount.innerText = 0;
                        @elseif(request()->is('admin/contact-enquiries'))
                            fetch("{{ route('admin.dispatcher.mark_contact_enquiries_as_viewed') }}")
                            contactEnquiriesCount.innerText = 0;
                        @endif

                        setInterval(async () => {
                            const previousTripsCount = parseInt(localStorage.getItem('dispatcherTripsCount') || 0);
                            const previousUsersCount = parseInt(localStorage.getItem('dispatcherUsersCount') || 0);
                            const previousProvidersCount = parseInt(localStorage.getItem('dispatcherProvidersCount') || 0);
                            const previousContactEnquiriesCount = parseInt(localStorage.getItem('dispatcherContactEnquiriesCount') || 0);
                            const previousBookingRequestsFormCount = parseInt(localStorage.getItem('dispatcherBookingRequestsFormCount') || 0);
                            

                            const res = await fetch("{{ route('admin.dispatcher.data-count') }}")
                            const { 
                                    trips_count, 
                                    users_count, 
                                    providers_count,
                                    contact_enquiries_count,
                                    booking_requests_form_count
                                 } = await res.json();

                            dispatcherTripsCount.innerText = trips_count;
                            dispatcherUsersCount.innerText = users_count;
                            dispatcherProvidersCount.innerText = providers_count;
                            bookingRequestsFormCount.innerText = booking_requests_form_count;
                            contactEnquiriesCount.innerText = contact_enquiries_count;

                            @if(Setting::get('play_bell', 0))
                            if (
                                    trips_count > previousTripsCount || 
                                    users_count > previousUsersCount ||
                                    providers_count > previousProvidersCount ||
                                    booking_requests_form_count > previousBookingRequestsFormCount ||
                                    contact_enquiries_count > previousContactEnquiriesCount   
                                )
                                bell.play();
                            @endif

                            localStorage.setItem('dispatcherTripsCount', trips_count);
                            localStorage.setItem('dispatcherUsersCount', users_count);
                            localStorage.setItem('dispatcherProvidersCount', providers_count);
                            localStorage.setItem('dispatcherContactEnquiriesCount', contact_enquiries_count);
                            localStorage.setItem('dispatcherBookingRequestsFormCount', booking_requests_form_count);

                        }, 3000);
                    }
                    </script>
                @endif
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' ||  
                    Auth::guard('admin')->user()->type == 'admin' ||
                    Auth::guard('admin')->user()->type == 'manager')
                    <li class="nav-item">
                        <a href="{{ route('admin.heatmap') }}"
                           class="nav-link {{ request()->is('admin/heatmap') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-map"></i>
                            <p>Eagle Eye</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.push.index') }}"
                           class="nav-link {{ request()->is('admin/push') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-bell"></i>
                            <p>Push Notifications</p>
                        </a>
                    </li>
                @endif
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' || 
                    Auth::guard('admin')->user()->type == 'admin' ||
                    Auth::guard('admin')->user()->type == 'customer_service' ||  
                    Auth::guard('admin')->user()->type == 'manager'
                )
                    <li class="nav-item">
                        <a href="{{ route('admin.review') }}"
                           class="nav-link {{ request()->is('admin/review') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-window-restore"></i>
                            <p> Reviews</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.cancellations') }}"
                           class="nav-link {{ request()->is('admin/cancellations') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-trash"></i>
                            <p> Cancellations</p>
                        </a>
                    </li>
                @endif
                
                {{-- @if(Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == 'customer_service')
                <li class="nav-item">
                    <a href="{{ route('admin.booking-requests-app') }}"
                        class="nav-link {{ request()->is('admin/booking-requests-app') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-car"></i>
                        <p> Booking Requests - Apps</p>
                    </a>
                </li>
                @endif --}}
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' || 
                    Auth::guard('admin')->user()->type == 'admin' ||
                    Auth::guard('admin')->user()->type == 'customer_service' ||  
                    Auth::guard('admin')->user()->type == 'manager'
                )
                    <li class="nav-item">
                        <a href="{{ route('admin.contact-enquiries') }}"
                           class="nav-link {{ request()->is('admin/contact-enquiries') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-envelope-open"></i>
                            <p> Contact Enquiries</p>
                            <span id="contact-enquiries-count" class="badge {{ request()->is('admin/contact-enquiries') ? 'badge-light' : 'badge-danger' }}">0</span>
                        </a>
                    </li>
                @endif
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' || 
                    Auth::guard('admin')->user()->type == 'admin' ||
                    Auth::guard('admin')->user()->type == 'customer_service' ||  
                    Auth::guard('admin')->user()->type == 'manager'
                )
                    <li class="nav-item">
                        <a href="{{ route('admin.map.index') }}"
                           class="nav-link {{ request()->is('admin/map') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-eye"></i>
                            <p> Country View</p>
                        </a>
                    </li>
                @endif
                {{--
                <li class="nav-item">
                   <a class="nav-link">
                      <i class="nav-icon"></i>
                      <p>User Type</p>
                   </a>
                </li>
                --}}
                @if(Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == 'admin')
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/admin') || request()->is('admin/admin/*') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/admin') || request()->is('admin/admin/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Admins
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.admin.index') }}"
                                   class="nav-link {{ request()->is('admin/admin') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Admins</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.admin.create') }}"
                                   class="nav-link {{ request()->is('admin/admin/create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' || 
                    Auth::guard('admin')->user()->type == 'admin' ||
                    Auth::guard('admin')->user()->type == 'customer_service' ||  
                    Auth::guard('admin')->user()->type == 'manager' ||
                    Auth::guard('admin')->user()->type == 'user_observer'
                )
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/user') || request()->is('admin/user/*') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/user') || request()->is('admin/user/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                                <span id="dispatcher-users-count" class="badge {{ request()->is('admin/user') ? 'badge-light' : 'badge-danger' }}">0</span>
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.user.index') }}"
                                   class="nav-link {{ request()->is('admin/user') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Users</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.user.create') }}"
                                   class="nav-link {{ request()->is('admin/user/create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' || 
                    Auth::guard('admin')->user()->type == 'admin' ||
                    Auth::guard('admin')->user()->type == 'customer_service' ||  
                    Auth::guard('admin')->user()->type == 'manager' ||
                    Auth::guard('admin')->user()->type == 'provider_observer'
                )
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/provider') || request()->is('admin/provider/*') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/provider') || request()->is('admin/provider/*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-taxi"></i>
                            <p>
                                Drivers
                                <span id="dispatcher-providers-count" class="badge {{ request()->is('admin/provider') ? 'badge-light' : 'badge-danger' }}">0</span>
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.provider.index') }}"
                                   class="nav-link {{ request()->is('admin/provider') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Drivers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.provider.create') }}"
                                   class="nav-link {{ request()->is('admin/provider/create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' || 
                    Auth::guard('admin')->user()->type == 'admin' || 
                    Auth::guard('admin')->user()->type == 'customer_service' ||  
                    Auth::guard('admin')->user()->type == 'manager' 
                )
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/dispatch-manager') || request()->is('admin/dispatch-manager/create') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/dispatch-manager') || request()->is('admin/dispatch-manager/create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Dispatcher
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.dispatch-manager.index') }}"
                                   class="nav-link {{ request()->is('admin/dispatch-manager') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Dispatchers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.dispatch-manager.create') }}"
                                   class="nav-link {{ request()->is('admin/dispatch-manager/create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New Dispatcher</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == 'admin')
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/account-manager') || request()->is('admin/account-manager/create') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/account-manager') || request()->is('admin/account-manager/create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-circle"></i>
                            <p>
                                Accountant
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.account-manager.index') }}"
                                   class="nav-link {{ request()->is('admin/account-manager') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Account Managers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.account-manager.create') }}"
                                   class="nav-link {{ request()->is('admin/account-manager/create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New Account Manager</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/fleet') || request()->is('admin/fleet/create') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/fleet') || request()->is('admin/fleet/create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>
                                Fleet Group
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.fleet.index') }}"
                                   class="nav-link {{ request()->is('admin/fleet') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Fleets</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.fleet.create') }}"
                                   class="nav-link {{ request()->is('admin/fleet/create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New Fleet</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if (Setting::get('subscription_module', '') == 1 && (Setting::get('rider_subscription_module', 0) == 1 || Setting::get('driver_subscription_module', 0) == 1))
                        <li
                                class="nav-item has-treeview {{ request()->is('admin/subscription-user') || request()->is('admin/subscription-user/create') || request()->is('admin/subscription-provider') || request()->is('admin/subscription-provider/create') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->is('admin/subscription-user') || request()->is('admin/subscription-user/create') || request()->is('admin/subscription-provider') || request()->is('admin/subscription-provider/create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-money"></i>
                                <p>
                                    Subscription(s)
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if (Setting::get('rider_subscription_module', 0) == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.subscription-user.index') }}"
                                        class="nav-link {{ request()->is('admin/subscription-user') || request()->is('admin/subscription-user/*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Rider Subscriptions</p>
                                        </a>
                                    </li>
                                @endif
                                @if (Setting::get('driver_subscription_module', 0) == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.subscription-provider.index') }}"
                                        class="nav-link {{ request()->is('admin/subscription-provider') || request()->is('admin/subscription-provider/*') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Driver Subscriptions</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    {{-- @if ((Setting::get('user_referral', 0) == 1 || Setting::get('driver_referral', 0) == 1))
                        <li
                                class="nav-item has-treeview {{ request()->is('admin/subscription') || request()->is('admin/subscription/create') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->is('admin/subscription') || request()->is('admin/subscription/create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-plus"></i>
                                <p>
                                    Referral(s)
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @if (Setting::get('rider_subscription_module', 0) == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.subscription-user.index') }}"
                                        class="nav-link {{ request()->is('admin/subscription-user') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Rider Subscriptions</p>
                                        </a>
                                    </li>
                                @endif
                                @if (Setting::get('driver_subscription_module', 0) == 1)
                                    <li class="nav-item">
                                        <a href="{{ route('admin.subscription-provider.index') }}"
                                        class="nav-link {{ request()->is('admin/subscription-provider') ? 'active' : '' }}">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Driver Subscriptions</p>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif --}}
                    @if (Setting::get('zone_module', '') == 1)
                        <li
                                class="nav-item has-treeview {{ request()->is('admin/zone') || request()->is('admin/zone/create') || request()->is('admin/zone-charges') || request()->is('admin/zone-charges/*') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->is('admin/zone') || request()->is('admin/zone/create') ||  request()->is('admin/zone-charges') || request()->is('admin/zone-charges/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-map"></i>
                                <p>
                                    Zones
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.zone.index') }}"
                                       class="nav-link {{ request()->is('admin/zone') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Zones</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.zone.create') }}"
                                       class="nav-link {{ request()->is('admin/zone/create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add New</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.zone-charges.index') }}" class="nav-link {{ request()->is('admin/zone-charges') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Zone Charges</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.zone-charges.create') }}" class="nav-link {{ request()->is('admin/zone-charges/create') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Add New Zone Charge</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li
                                class="nav-item has-treeview {{ request()->is('admin/zone-service') || request()->is('admin/zone-service/create') ? 'menu-open' : '' }}">
                            <a href="#"
                               class="nav-link {{ request()->is('admin/zone-service') || request()->is('admin/zone-service/create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-window-restore"></i>
                                <p>
                                    Zone Services
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('admin.zone-service.index') }}"
                                       class="nav-link {{ request()->is('admin/zone-service') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Zone with services</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                @endif
                {{--
                <li class="nav-item">
                   <a class="nav-link">
                      <i class="nav-icon"></i>
                      <p>Details</p>
                   </a>
                </li>
                --}}
                @if(Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == 'admin')
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/statement') || request()->is('admin/statement/provider') || request()->is('admin/statement/today') || request()->is('admin/statement/monthly') || request()->is('admin/statement/yearly') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/statement') || request()->is('admin/statement/provider') || request()->is('admin/statement/today') || request()->is('admin/statement/monthly') || request()->is('admin/statement/yearly') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-crown"></i>
                            <p>
                                Statements
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.ride.statement') }}"
                                   class="nav-link {{ request()->is('admin/statement') ? 'active' : '' }}">
                                    <i class="nav-icon"></i>
                                    <p>Overall Statments</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.ride.statement.provider') }}"
                                   class="nav-link {{ request()->is('admin/statement/provider') ? 'active' : '' }}">
                                    <i class="nav-icon"></i>
                                    <p>Provider Statement</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.ride.statement.today') }}"
                                   class="nav-link {{ request()->is('admin/statement/today') ? 'active' : '' }}">
                                    <i class="nav-icon"></i>
                                    <p>Daily Statement</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.ride.statement.monthly') }}"
                                   class="nav-link {{ request()->is('admin/statement/monthly') ? 'active' : '' }}">
                                    <i class="nav-icon"></i>
                                    <p>Monthly Statement</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.ride.statement.yearly') }}"
                                   class="nav-link {{ request()->is('admin/statement/yearly') ? 'active' : '' }}">
                                    <i class="nav-icon"></i>
                                    <p>Yearly Statement</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                    {{--
                    <li class="nav-item">
                       <a class="nav-link">
                          <i class="nav-icon"></i>
                          <p>General</p>
                       </a>
                    </li>
                    --}}
                    {{--
                    <li class="nav-item">
                       <a href="{{ route('admin.translation') }}" class="nav-link {{ request()->is('admin/dashboard') ? 'active' : ''  }}">
                          <i class="nav-icon fas fa-globe"></i>
                          <p> Translation</p>
                       </a>
                    </li>
                    --}}
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' || 
                    Auth::guard('admin')->user()->type == 'admin' || 
                    Auth::guard('admin')->user()->type == 'manager' 
                )

                    <li
                            class="nav-item has-treeview {{ request()->is('admin/document') || request()->is('admin/document/create') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/document') || request()->is('admin/document/create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                                Documents
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.document.index') }}"
                                   class="nav-link {{ request()->is('admin/document') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Documents</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.document.create') }}"
                                   class="nav-link {{ request()->is('admin/document/create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New Document</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/faqs') || request()->is('admin/faqs/create') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/faqs') || request()->is('admin/faqs/create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-file-alt"></i>
                            <p>
                                Faqs
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.faqs.index') }}"
                                   class="nav-link {{ request()->is('admin/faqs') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Faqs</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.faqs.create') }}"
                                   class="nav-link {{ request()->is('admin/faqs/create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New Faq</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/promocode') || request()->is('admin/promocode/create') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/promocode') || request()->is('admin/promocode/create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-percent"></i>
                            <p>
                                Promocodes
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.promocode.index') }}"
                                   class="nav-link {{ request()->is('admin/promocode') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Promo</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.promocode.create') }}"
                                   class="nav-link {{ request()->is('admin/promocode/create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New Promocode</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(Auth::guard('admin')->user()->type == 'superadmin' || Auth::guard('admin')->user()->type == 'admin')
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/service') || request()->is('admin/service/create') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/service') || request()->is('admin/service/create') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Services
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.service.index') }}"
                                   class="nav-link {{ request()->is('admin/service') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>All Services</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.service.create') }}"
                                   class="nav-link {{ request()->is('admin/service/create') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New Service</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' || 
                    Auth::guard('admin')->user()->type == 'admin' ||
                    Auth::guard('admin')->user()->type == 'customer_service' ||  
                    Auth::guard('admin')->user()->type == 'manager'
                )
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/requests') || request()->is('admin/scheduled') || request()->is('admin/meterhistory') || request()->is('admin/payment') || request()->is('admin/promocodes/usage') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/requests') || request()->is('admin/scheduled') || request()->is('admin/meterhistory') || request()->is('admin/payment') || request()->is('admin/promocodes/usage') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>
                                History
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.requests.index') }}"
                                   class="nav-link {{ request()->is('admin/requests') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-history"></i>
                                    <p>Past History</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.requests.scheduled') }}"
                                   class="nav-link {{ request()->is('admin/scheduled') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-clock"></i>
                                    <p>Upcoming Orders</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.ride.meterhistory') }}"
                                   class="nav-link {{ request()->is('admin/meterhistory') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-car"></i>
                                    <p>TaxiMeter History</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.payment') }}"
                                   class="nav-link {{ request()->is('admin/payment') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-wallet"></i>
                                    <p>Payment History</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.promocode.usage') }}"
                                   class="nav-link {{ request()->is('admin/promocodes/usage') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-plus"></i>
                                    <p>Promocode History</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                {{-- @if (\Setting::get('demo_mode', 0) == 0) --}}
                @if(Auth::guard('admin')->user()->type == 'superadmin')
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/settings') || request()->is('admin/settings/appsetting') || request()->is('admin/settings/payment') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/settings') || request()->is('admin/settings/appsetting') || request()->is('admin/settings/payment') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cogs"></i>
                            <p>
                                Settings
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        {{-- <li class="nav-item">
                            <a href="{{ route('admin.subadmin') }}"
                                class="nav-link {{ request()->is('admin/subadmin') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-pie-chart"></i>
                                <p>Subadmin</p>
                            </a>
                        </li> --}}
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.settings') }}"
                                   class="nav-link {{ request()->is('admin/settings') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-cog"></i>
                                    <p>Web Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.settings.appsetting') }}"
                                   class="nav-link {{ request()->is('admin/settings/appsetting') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-mobile-alt"></i>
                                    <p>App Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.settings.payment') }}"
                                   class="nav-link {{ request()->is('admin/settings/payment') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-key"></i>
                                    <p>Payment Settings</p>
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a href="{{ route('admin.subadmin') }}"
                                    class="nav-link {{ request()->is('admin/subadmin') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-key"></i>
                                    <p>Permissions</p>
                                </a>
                            </li> --}}
                        </ul>
                    </li>
                @endif
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' || 
                    Auth::guard('admin')->user()->type == 'customer_service'
                )
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/privacy') || request()->is('admin/terms') || request()->is('admin/driver') || request()->is('admin/about') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/privacy') || request()->is('admin/terms') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-th-large"></i>
                            <p>
                                Extra
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.privacy') }}"
                                   class="nav-link {{ request()->is('admin/privacy') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-secret"></i>
                                    <p>Privacy Policy</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.terms') }}"
                                   class="nav-link {{ request()->is('admin/terms') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-info-circle"></i>
                                    <p>Terms & Conditions</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.driver') }}"
                                   class="nav-link {{ request()->is('admin/driver') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>Driver - Page &nbsp;&nbsp;&nbsp;</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.about') }}"
                                   class="nav-link {{ request()->is('admin/about') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-circle"></i>
                                    <p>About us</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' || 
                    Auth::guard('admin')->user()->type == 'admin' ||
                    Auth::guard('admin')->user()->type == 'customer_service'
                )
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/profile') || request()->is('admin/password') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/profile') || request()->is('admin/password') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Account
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.profile') }}"
                                   class="nav-link {{ request()->is('admin/profile') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>Account Settings</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.password') }}"
                                   class="nav-link {{ request()->is('admin/password') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-exchange-alt"></i>
                                    <p>Change Passowrd</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif
                @if(
                    Auth::guard('admin')->user()->type == 'superadmin' || 
                    Auth::guard('admin')->user()->type == 'admin' ||
                    Auth::guard('admin')->user()->type == 'customer_service'
                )
                    <li
                            class="nav-item has-treeview {{ request()->is('admin/profile') || request()->is('admin/password') ? 'menu-open' : '' }}">
                        <a href="#"
                           class="nav-link {{ request()->is('admin/profile') || request()->is('admin/password') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                Role & Permission
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('admin.role.index') }}"
                                   class="nav-link {{ request()->routeIs('admin.role.index') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>User Role</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.password') }}"
                                   class="nav-link {{ request()->is('admin/password') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-exchange-alt"></i>
                                    <p>Role Permissions</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif
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
