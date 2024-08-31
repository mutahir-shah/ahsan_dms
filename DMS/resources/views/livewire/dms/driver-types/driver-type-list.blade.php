<div>
    <x-layouts.breadcrum
        :main_menu="$main_menu"
        :menu="$menu"
    />
    <x-ui.message />
    <x-ui.row>
        <x-ui.col class="col-lg-12">
            <x-ui.card>
                <x-ui.card-header title="Driver Type List" :href="route('driver-types.create')"/>
                <x-ui.card-body>
                    <x-ui.table>
                        <x-ui.thead>
                            @php
                                $table_headings = ['#', 'Driver Type', 'Fields','Action'];
                            @endphp
                            @foreach ($table_headings as $heading)
                                <x-ui.th :label="$heading" wire:key="{{ $loop->iteration }}"/>
                            @endforeach
                        </x-ui.thead>
                        <x-ui.tbody>
                            @foreach ($driverTypes as $driverType)
                                <x-ui.tr wire:key="{{ $loop->iteration }}">
                                    <x-ui.td>{{ $loop->iteration }}</x-ui.td>
                                    <x-ui.td>{{ $driverType->name }}</x-ui.td>
                                    <x-ui.td>{{ $driverType->fields }}</x-ui.td>

                                    <x-ui.td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="{{ route('driver-types.edit', $driverType->id) }}" wire:navigate class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> @translate('Edit')</a></li>
                                                <li>
                                                    <a class="dropdown-item remove-item-btn">
                                                        <i class="ri-delete-bin-fill align-bottom me-2 text-muted"></i> @translate('Delete')
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </x-ui.td>
                                </x-ui.tr>
                            @endforeach
                        </x-ui.tbody>
                    </x-ui.table>
                </x-ui.card-body>
            </x-ui.card>
        </x-ui.col>
    </x-ui.row>
</div>
