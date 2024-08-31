<div>
    <x-layouts.breadcrum
        :main_menu="$main_menu"
        :menu="$menu"
    />

    <x-ui.message />
    <x-ui.row>
        <x-ui.col class="col-lg-12">
            <x-ui.card>
                <x-ui.card-header title="Employee List" :href="route('employee.create')"/>
                <x-ui.card-body>
                    <x-ui.table>
                        <x-ui.thead>
                            @php
                                $table_headings = ['#', 'Employee ID', 'Name', 'Email', 'User Role', 'Status', 'Action'];
                            @endphp
                            @foreach ($table_headings as $heading)
                                <x-ui.th :label="$heading" wire:key="{{ $loop->iteration }}"/>
                            @endforeach
                        </x-ui.thead>
                        <x-ui.tbody>
                            @foreach ($employees as $employee)
                                <x-ui.tr wire:key="{{ $loop->iteration }}">
                                    <x-ui.td>{{ $loop->iteration }}</x-ui.td>
                                    <x-ui.td>EMP0{{ $employee->id }}</x-ui.td>
                                    <x-ui.td>{{ $employee->name }}</x-ui.td>
                                    <x-ui.td><a href="#!">{{ $employee->email }}</a></x-ui.td>
                                    <x-ui.td>{{ $employee->role->name }}</x-ui.td>
                                    <x-ui.td><span class="badge bg-success-subtle text-success">Active</span></x-ui.td>
                                    <x-ui.td>
                                        <div class="dropdown d-inline-block">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a href="#!" class="dropdown-item"><i class="ri-eye-fill align-bottom me-2 text-muted"></i> @translate('View')</a></li>
                                                <li><a href="{{ route('employee.edit', $employee->id) }}" wire:navigate class="dropdown-item edit-item-btn"><i class="ri-pencil-fill align-bottom me-2 text-muted"></i> @translate('Edit')</a></li>
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
