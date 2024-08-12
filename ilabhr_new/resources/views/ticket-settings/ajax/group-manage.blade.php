<div class="table-responsive p-20">
    <x-table class="table-bordered">
        <x-slot name="thead">
            <th>@lang('app.name')</th>
            <th class="text-right">@lang('app.action')</th>
        </x-slot>

        @forelse($groups as $group)
            <tr class="row{{ $group->id }}">
                <td>
                    {{ $group->group_name }}
                </td>

                <td class="text-right">
                    <div class="task_view">
                        <a href="javascript:;" data-group-id="{{ $group->id }}"
                            class="edit-group task_view_more d-flex align-items-center justify-content-center dropdown-toggle">
                            <i class="fa fa-edit icons mr-2"></i> @lang('app.edit')
                        </a>
                    </div>
                    <div class="task_view">
                        <a href="javascript:;" data-group-id="{{ $group->id }}"
                            class="delete-group task_view_more d-flex align-items-center justify-content-center dropdown-toggle">
                            <i class="fa fa-trash icons mr-2"></i> @lang('app.delete')
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4">
                    <x-cards.no-record icon="user" :message="__('messages.noAgentAdded')" />
                </td>
            </tr>
        @endforelse
    </x-table>
</div>
