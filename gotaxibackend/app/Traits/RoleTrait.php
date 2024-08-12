<?php 

namespace App\Traits;

use App\Module;
use App\Privilege;
use App\Role;

trait RoleTrait{
    public function storeRoles(){
        $roles = $this->getRoles();
        foreach($roles as $item){
            Role::truncate();
            $role = Role::create($item);
            $modules = Module::orderBy('sort','asc')->get();
            foreach($modules as $module)
            {
                Privilege::create([
                    'role_id' => $role->id,
                    'module_id' => $module->id,
                    'is_view' => 1,
                    'is_view_all_data' => 1,
                    'is_add' => 1,
                    'is_edit' => 1,
                    'is_notify' => 1,
                    'is_delete' => 1,
                    'is_status' => 1,
                ]);
            }
        }
    }
    public function getRoles(){
        return [
            [
                'name' => 'Super Admin',
                'is_default' => 1
            ],
            // [
            //     'name' => 'Dispatcher',
            //     'is_default' => 1
            // ],
            // [
            //     'name' => 'Account',
            //     'is_default' => 1
            // ],
            // [
            //     'name' => 'Fleet',
            //     'is_default' => 1
            // ],
        ];
    }
}