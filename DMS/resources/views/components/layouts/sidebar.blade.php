<div class="app-menu navbar-menu">
    <!-- Begin: Navbar Brand -->
    <x-ui.navbar-brand/>
    <!-- End: Navbar Brand -->

    <!-- Begin: Sidebar Menu -->
    <div id="scrollbar">
        <div class="container-fluid">
            <div id="two-column-menu"></div>
            <ul class="navbar-nav" id="navbar-nav">
                <!-- Begin: Seprater -->
                <x-ui.sidebar.seprater name="Menu"/>
                <!-- End: Seprater -->

                <!-- Begin: Module Listing -->
                @foreach (getModules() as $module)
                    <x-ui.sidebar.menu
                        :isCollapsed="$module->is_collapseable"
                        :dataId="$module->data_id"
                        :route="$module->route"
                        :icon="$module->icon"
                        :dataKey="$module->data_key"
                        :label="$module->name"
                        >
                        @foreach ($module->modules as $sub_module)
                            <x-ui.sidebar.menu-item
                                :label="$sub_module->name"
                                :route="$sub_module->route"
                            />
                        @endforeach
                    </x-ui.sidebar.menu>
                @endforeach
                <!-- End: Module Listing -->

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <!-- End: Sidebar Menu -->

    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
