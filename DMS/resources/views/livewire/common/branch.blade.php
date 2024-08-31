<x-ui.col class="col-lg-3 col-md-3 mb-3">
    <x-form.label for="branch_id" name="Branch" :required='true'/>
    <x-form.select class="form-select" wire:model='branch_id'>
        @foreach ($branches as $item)
            <x-form.option value="{{ $item->id }}" :name="$item->name"/>
        @endforeach
    </x-form.select>
    <x-ui.alert error="branch_id"/>
</x-ui.col>
