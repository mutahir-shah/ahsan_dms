<?php

namespace App\Traits;

use App\Admin;
use App\Module;
use App\Privilege;

trait ModuleExtendTrait
{
    public function storeModulesExtended()
    {
        $modules = $this->getModulesExtended();
        foreach ($modules as $module) {
            Module::create($module);
        }
    }

    public function getModulesExtended()
    {
        return [
            [ // 90
                'name' => 'CMS',
                'route' => '',
                'icon' => 'fa-user',
                'is_view' => 0,
                'is_view_all_data' => 0,
                'is_add' => 0,
                'is_edit' => 0,
                'is_notify' => 0,
                'is_status' => 0,
                'is_delete' => 0,
                'type' => 1,
                'badged' => 0,
                'parent' => 0,
                'sort' => 21,
            ],
            [ // 88
                'name' => 'App CMS',
                'route' => 'admin.csm.app',
                'icon' => 'fa-exchange-alt',
                'is_view' => 1,
                'is_view_all_data' => 0,
                'is_add' => 1,
                'is_edit' => 1,
                'is_notify' => 0,
                'is_status' => 0,
                'is_delete' => 1,
                'type' => 2,
                'badged' => 0,
                'parent' => 90,
                'sort' => 5,
            ],
            [ // 88
                'name' => 'Website CMS',
                'route' => 'admin.cms.web',
                'icon' => 'fa-exchange-alt',
                'is_view' => 1,
                'is_view_all_data' => 0,
                'is_add' => 1,
                'is_edit' => 1,
                'is_notify' => 0,
                'is_status' => 0,
                'is_delete' => 1,
                'type' => 2,
                'badged' => 0,
                'parent' => 90,
                'sort' => 5,
            ]
        ];
    }
}
