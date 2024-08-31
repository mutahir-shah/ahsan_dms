<?php

namespace App\Repositories;

use App\Interfaces\DriverInterface;
use App\Models\{Driver};

class DriverRepository implements DriverInterface
{
    public function all()
    {
        return Driver::all();
    }

    public function create(array $data)
    {
        return Driver::create($data);
    }

    public function update(array $data, $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->update($data);
        return $driver;
    }

    public function delete($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();
    }

    public function find($id)
    {
        return Driver::findOrFail($id);
    }
}
