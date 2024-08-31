@props([
    'href' => false,
    'title' => ''
])

<div class="card-header flex justify-content-between">
    <h5 class="card-title mb-0">@translate($title)</h5>
    @if ($href)
        <a href="{{ $href }}" class="btn btn-success" wire:navigate><i class="ri-add-line align-bottom me-1"></i> @translate('Add New')</a>
    @endif
</div>
