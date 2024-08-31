<?php
namespace App\Livewire\Employee;

use App\Services\EmployeeService;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Employee List')]
class EmployeeList extends Component
{
    protected EmployeeService $employeeService;
    private string $main_menu  = 'Employees';
    private string $menu  = 'Employee List';

    public function mount(EmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
    }

    public function render()
    {
        $employees = $this->employeeService->all();
        $main_menu = $this->main_menu;
        $menu = $this->menu;
        return view('livewire.employee.employee-list', compact('employees', 'main_menu', 'menu'));
    }


}
