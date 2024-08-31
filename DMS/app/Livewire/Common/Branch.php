<?php

namespace App\Livewire\Common;

use App\Services\BranchService;
use Livewire\Attributes\Modelable;
use Livewire\Component;

class Branch extends Component
{
    #[Modelable]
    public $branch_id = '';

    protected BranchService $branchService;

    public function mount(BranchService $branchService): void
    {
        $this->branchService = $branchService;
    }

    public function render()
    {
        $branches = cache()->rememberForever('branches', function () {
            return $this->branchService->all();
        });

        return view('livewire.common.branch', compact('branches'));
    }
}
