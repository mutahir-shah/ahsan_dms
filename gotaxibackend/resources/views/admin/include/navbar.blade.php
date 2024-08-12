<style>
    .nav-pills .nav-link.active, .nav-pills .show>.nav-link {
        color: #fff !important;
        background-color: {{ Setting::get('site_color') }}!important;
    }
    .nav-pills .nav-link.active::hover, .nav-pills .show>.nav-link:hover {
        color: #fff !important;
        background-color: {{ Setting::get('site_color') }}!important;
    }
    .nav-sidebar .nav-item>.nav-link:hover {
        color: #232345;
    }  
   .brand-text {
        color: #232345;
        font-weight: bold !important;
        
    }
</style>
<aside class="main-sidebar" style="background: #ffffff;">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="{{ Setting::get('site_logo', asset('')) }}" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">{{ Setting::get('site_title', '') }}</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            @php
                $modules = \App\Helpers\Helper::getModules();
            @endphp

            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                   with font-awesome or any other icon font library -->
            
                @foreach ($modules as $module)
                    @if ($module->name != 'Faqs')    
                        @php
                            $checkPermission = \App\Helpers\Helper::getModulePrivilege($module->id);
                        @endphp
                        @if ($module->id == 64)
                            @if ($module->operations->count())
                                @foreach ($module->operations as $operation_item)
                                    @php 
                                        $checkOperationPermission = \App\Helpers\Helper::getModulePrivilege($operation_item->id);
                                    @endphp
                                    @if ($checkOperationPermission)
                                    <li class="nav-item">
                                        <a href="{{ $module->route ? route($module->route) : '' }}"
                                            class="nav-link {{ $module->route && request()->routeIs($module->route) ? 'active' : '' }}">
                                            <i class="nav-icon fas {{ $module->icon }}"></i>
                                            <p>{{ translateKeyword($module->name) }}</p>
                                        </a>
                                    </li>
                                        @break;
                                    @endif
                                    
                                @endforeach
                            @endif
                        @endif
                        @if ($module->type == 1 && !$module->operations->count())
                            @if (!is_null($checkPermission))
                                <li class="nav-item">
                                    <a href="{{ $module->route ? route($module->route) : '' }}"
                                        class="nav-link {{ $module->route && request()->routeIs($module->route) ? 'active' : '' }}">
                                        <i class="nav-icon fas {{ $module->icon }}"></i>
                                        <p>{{ translateKeyword($module->name) }}</p>
                                    </a>
                                </li>
                            @endif
                        @elseif($module->type == 3)
                            <li class="nav-item" style="margin-top: 10px;">
                                <a class="nav-link">
                                    <i class="nav-icon"></i>
                                    <p>{{ translateKeyword($module->name) }}</p>
                                </a>
                            </li>
                        @elseif($module->id != 64)
                            @php
                                $hasRoutes = $module->operations->contains(function ($operation) {
                                    return request()->routeIs($operation->route);
                                });
                                $hasPrivilege = $module->operations->contains(function ($operation) {
                                    return \App\Helpers\Helper::getModulePrivilege($operation->id) !== null;
                                });
                            @endphp
                            @if ($hasPrivilege)
                                <li class="nav-item has-treeview {{ $hasRoutes ? 'menu-open' : '' }}">
                                    <a href="#"
                                        class="nav-link {{ $module->route && request()->routeIs($module->route) ? 'active' : '' }}">
                                        <i class="nav-icon fas {{ $module->icon }}"></i>
                                        <p>
                                            {{ translateKeyword($module->name) }}
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach ($module->operations as $operation)
                                            @php
                                                $checkOperationPermission = \App\Helpers\Helper::getModulePrivilege(
                                                    $operation->id,
                                                );
                                            @endphp
                                            @if (!is_null($checkOperationPermission))
                                                <li class="nav-item">
                                                    <a href="{{ $operation->route ? route($operation->route) : '' }}"
                                                        class="nav-link {{ $operation->route && request()->routeIs($operation->route) ? 'active' : '' }}">
                                                        <i class="nav-icon fas {{ $operation->icon }}"></i>
                                                        <p>{{ translateKeyword($operation->name) }}</p>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @endif
                        @endif
                    @endif
                @endforeach

                <li class="nav-item">
                    <a href="{{ url('/admin/logout') }}" class="nav-link"
                        onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-power-off"></i>
                        <p>{{ translateKeyword('Logout') }}</p>
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
