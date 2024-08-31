<?php

namespace App\Livewire\DMS\Drivers;

use App\Services\DriverService;
use Livewire\Component;

class DriverList extends Component
{
    protected DriverService $driverService;
    private string $main_menu  = 'Drivers';
    private string $menu  = 'Driver List';

    public function mount(DriverService $driverService)
    {
        $this->driverService = $driverService;
    }

    public function render()
    {
        $drivers = $this->driverService->all();
        $main_menu = $this->main_menu;
        $menu = $this->menu;
        return view('livewire.dms.drivers.driver-list', compact('drivers', 'main_menu', 'menu'));
    }
}
