<?php

namespace App\Repositories;

use App\Interfaces\RoleInterface;
use App\Models\Role;

class RoleRepository implements RoleInterface
{
    public function all()
    {
        return Role::all();
    }

    public function create(array $data)
    {
        return Role::create($data);
    }

    public function update(array $data, $id)
    {
        $user = Role::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = Role::findOrFail($id);
        $user->delete();
    }

    public function find($id)
    {
        return Role::findOrFail($id);
    }
}
