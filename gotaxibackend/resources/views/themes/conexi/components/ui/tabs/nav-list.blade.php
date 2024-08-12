<ul class="nav nav-tabs tab-title" role="tablist">
    {{ $slot }}
</ul>


@component('themes.conexi.components.ui.tabs.nav-list')
                    @foreach (getServicesList() as $key => $list_item)
                        @component('themes.conexi.components.ui.tabs.nav-item', [
                            'service_name' => $list_item['name'], 
                            'service_title' => $list_item['title'],
                            'is_active' => $key == 0
                        ])
                        @endcomponent
                    @endforeach
                @endcomponent