<!-- <div class="col-md-3">
    <div class="dash-left">
        <div class="user-img">
            <?php $profile_image = img(Auth::user()->picture); ?>
        <div class="pro-img" style="background-image: url({{$profile_image}});"></div>
            <h4>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h4>
        </div>
        <div class="side-menu">
             <ul>
                <li><a href="{{url('dashboard')}}">{{ translateKeyword('dashboard') }}</a></li>
                <li><a href="{{url('trips')}}">{{ translateKeyword('my_trips') }}</a></li>
                <li><a href="{{url('upcoming/trips')}}">{{ translateKeyword('upcoming_trips') }}</a></li>
                <li><a href="{{url('profile')}}">{{ translateKeyword('profile') }}</a></li>
                <li><a href="{{url('change/password')}}">{{ translateKeyword('change_password') }}</a></li>
                <li><a href="{{url('/payment')}}">{{ translateKeyword('payment') }}</a></li>
                <li><a href="{{url('/promotions')}}">{{ translateKeyword('promotion') }}</a></li>
                <li><a href="{{url('/wallet')}}">{{ translateKeyword('my_wallet') }} <span class="pull-right">{{currency(Auth::user()->wallet_balance)}}</span></a></li>
                <li><a href="{{ url('/logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">{{ translateKeyword('logout') }}</a></li>
                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
</form>
</ul>
</div>
</div>
</div> -->