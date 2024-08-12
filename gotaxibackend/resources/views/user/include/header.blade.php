<header class="header_area">
    <div class="container-fluid d-flex">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a href="{{url('dashboard')}}" class="logo"><img style="height: 80px"
                                                             src="{{Setting::get('site_logo', '')}}" alt=""></a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="menu_toggle">
                    <span class="hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    <span class="hamburger-cross">
                        <span></span>
                        <span></span>
                    </span>
                </span>
            </button>
            <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                <ul class="nav navbar-nav menu mr-auto">
                    @if(Setting::get('negotiation_module', 0) == 0 && request()->user()->status !== 'doc_required')
                        <li class="nav-item {{ request()->is('dashboard') || request()->is('new-job') ? 'active' : '' }}"><a class="nav-link" href="{{url('dashboard')}}">{{ translateKeyword('dashboard') }}</a></li>
                    @endif
                    <li class="nav-item {{ request()->is('profile*') ? 'active' : '' }}"><a class="nav-link" href="{{url('profile')}}">{{ translateKeyword('my_profile') }}</a></li>
                    @if(request()->user()->status !== 'doc_required')
                        <li class="nav-item {{ request()->is('trips') ? 'active' : '' }}"><a class="nav-link" href="{{url('trips')}}">{{ translateKeyword('my_trips') }}</a></li>
                        <li class="nav-item {{ request()->is('upcoming/trips') ? 'active' : '' }}"><a class="nav-link" href="{{url('upcoming/trips')}}">{{ translateKeyword('upcoming_trips') }}</a></li>
                        <li class="nav-item {{ request()->is('promotions') ? 'active' : '' }}"><a class="nav-link" href="{{url('/promotions')}}">{{ translateKeyword('Coupons') }}</a></li>
                        @if(Setting::get('CARD', 0) == 1)
                            <li class="nav-item {{ request()->is('wallet') ? 'active' : '' }}"><a class="nav-link" href="{{url('/wallet')}}">{{ translateKeyword('my_wallet') }}</a></li>
                            @if (Setting::get('manage_card_passenger', 0) == 1)
                                <li class="nav-item {{ request()->is('cards') ? 'active' : '' }}"><a class="nav-link" href="{{url('/cards')}}">{{ translateKeyword('my_cards') }}</a></li>
                            @endif
                        @endif
                    @endif
                </ul>
            </div>
        </nav>
        <div class="menu_btn">
            <a href="{{ url('/logout') }}" class="book_btn"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ translateKeyword('logout') }}</a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            <a href="javascript:">
                <div id="google_translate_element"
                     style="padding-right: 10px; padding-left:20px; margin-left: 10%; float: right;"></div>
            </a>
        </div>
    </div>
</header>
