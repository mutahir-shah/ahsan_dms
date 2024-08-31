<?php

namespace App\Services;

use App\Repositories\DriverRepository;
use Illuminate\Support\Facades\{DB, Log};

class DriverService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected DriverRepository $driverRepository)
    {
        //
    }

    public function create(array $data)
    {
        DB::beginTransaction();
        try{
            $driver = $this->driverRepository->create($data);
            Log::info("Driver Created", ['driver' => $driver]);
            DB::commit();
            return $driver;
        }catch(\Exception $e){
            Log::error("Driver Create Error", ['error' => $e]);
            DB::rollBack();
        }
    }

    public function update(array $data, $id)
    {
        DB::beginTransaction();
        try{
            $driver = $this->driverRepository->update($data, $id);
            Log::info("Driver Updated", ['driver' => $driver]);
            DB::commit();
            return $driver;
        }catch(\Exception $e){
            Log::error("Driver Update Error", ['error' => $e]);
            DB::rollBack();
        }
    }

    public function delete($id)
    {
        return $this->driverRepository->delete($id);
    }

    public function all()
    {
        return $this->driverRepository->all();
    }

    public function find($id)
    {
        return $this->driverRepository->find($id);
    }

}
