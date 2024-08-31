<?php

namespace App\Livewire\DMS\DriverTypes;

use App\Services\DriverTypeService;
use Livewire\Component;

class DriverTypeList extends Component
{
    protected DriverTypeService $driverTypeService;
    private string $main_menu  = 'Driver Types';
    private string $menu  = 'Driver Type List';

    public function mount(DriverTypeService $driverTypeService)
    {
        $this->driverTypeService = $driverTypeService;
    }

    public function render()
    {
        $driverTypes = $this->driverTypeService->all();
        $main_menu = $this->main_menu;
        $menu = $this->menu;
        return view('livewire.dms.driver-types.driver-type-list', compact('driverTypes', 'main_menu', 'menu'));
    }
}
