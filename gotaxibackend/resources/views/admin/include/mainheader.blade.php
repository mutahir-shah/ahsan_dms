<div class="main-header">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>


        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
            <span style="height: 25px, width: 25px;">
               <img src="{{ asset('storage/' . Auth::guard('admin')->user()->picture)}}" style=" height: 30px; " alt="">
            </span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('admin.profile')}}">
                        <i class="ti-user mr-0-5"></i> {{ translateKeyword('profile')}}
                    </a>
                    <a class="dropdown-item" href="{{route('admin.password')}}">
                        <i class="ti-settings mr-0-5"></i> {{ translateKeyword('change_password')}}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ url('/admin/logout') }}"
                       onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"><i class="ti-power-off mr-0-5"></i> {{translateKeyword('sign_out') }}</a>
                </div>
            </li>
            <!-- <li class="nav-item">
              <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
                  class="fas fa-th-large"></i></a>
            </li> -->
        </ul>
    </nav>
</div>
