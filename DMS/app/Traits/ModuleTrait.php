<?php

namespace App\Traits;

use App\Models\Module;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

trait ModuleTrait
{
    public function storeModules(){
        DB::beginTransaction();
        try {

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Module::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            Module::insert($this->getModules());

            DB::commit();
        } catch (\Exception $e) {
            Log::error('Store Module Error: ' . $e->getMessage());
            DB::rollBack();
        }
    }

    public function getModules(){
        return [
            // 1
            [
                'name' => 'Dashboard',
                'icon' => 'ri-dashboard-2-line',
                'data_key' => 't-widgets',
                'data_id' => '',
                'route' => 'dashboard',
                'type' => 1,
                'parent_id' => null,
                'is_collapseable' => false,
                'index' => 1
            ],
            // 2
            [
                'name' => 'HR',
                'icon' => 'ri-team-line',
                'data_key' => 't-dashboards',
                'data_id' => 'sidebarHRs',
                'route' => '',
                'type' => 1,
                'parent_id' => null,
                'is_collapseable' => true,
                'index' => 2
            ],
            // 3
            [
                'name' => 'Employees',
                'icon' => 'ri-dashboard-2-line',
                'data_key' => 't-analytics',
                'data_id' => '',
                'route' => 'employee.index',
                'type' => 2,
                'parent_id' => 2,
                'is_collapseable' => false,
                'index' => 1
            ],
            // 4
            [
                'name' => 'DMS',
                'icon' => 'ri-takeaway-line',
                'data_key' => 't-dashboards',
                'data_id' => 'sidebarDMSs',
                'route' => '',
                'type' => 1,
                'parent_id' => null,
                'is_collapseable' => true,
                'index' => 3
            ],
            // 5
            [
                'name' => 'Driver Types',
                'icon' => 'ri-dashboard-2-line',
                'data_key' => 't-analytics',
                'data_id' => '',
                'route' => 'driver-types.index',
                'type' => 2,
                'parent_id' => 4,
                'is_collapseable' => true,
                'index' => 1
            ],
            // 6
            [
                'name' => 'Drivers',
                'icon' => 'ri-dashboard-2-line',
                'data_key' => 't-analytics',
                'data_id' => '',
                'route' => 'drivers.index',
                'type' => 2,
                'parent_id' => 4,
                'is_collapseable' => true,
                'index' => 2
            ],
            // 7
            [
                'name' => 'Businesses',
                'icon' => 'ri-dashboard-2-line',
                'data_key' => 't-analytics',
                'data_id' => '',
                'route' => 'business.index',
                'type' => 2,
                'parent_id' => 4,
                'is_collapseable' => true,
                'index' => 3
            ],
            // 8
            [
                'name' => 'Payroll',
                'icon' => 'ri-dashboard-2-line',
                'data_key' => 't-analytics',
                'data_id' => '',
                'route' => 'drivers.index',
                'type' => 2,
                'parent_id' => 4,
                'is_collapseable' => true,
                'index' => 4
            ],
            // 8
            [
                'name' => 'Revenue Reporting',
                'icon' => 'ri-dashboard-2-line',
                'data_key' => 't-analytics',
                'data_id' => '',
                'route' => 'drivers.index',
                'type' => 2,
                'parent_id' => 4,
                'is_collapseable' => true,
                'index' => 5
            ],
            // 8
            [
                'name' => 'Receipt Voucher',
                'icon' => 'ri-dashboard-2-line',
                'data_key' => 't-analytics',
                'data_id' => '',
                'route' => 'drivers.index',
                'type' => 2,
                'parent_id' => 4,
                'is_collapseable' => true,
                'index' => 6
            ],

        ];
    }
}
