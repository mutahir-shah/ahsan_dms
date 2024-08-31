<?php

use App\Livewire\Auth\{Login};
use App\Livewire\Dashboard;
use App\Livewire\Employee\{CreateEmployee, EditEmployee, EmployeeList};
use App\Livewire\DMS\DriverTypes\{CreateDriverType, DriverTypeList, EditDriverType};
use App\Livewire\DMS\Drivers\{CreateDriver, DriverList, EditDriver};
use App\Livewire\DMS\Businesses\{BusinessList, CreateBusiness, EditBusiness};
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->name('login');

Route::middleware('auth')->group(function(){

    Route::get('/', Dashboard::class)->name('dashboard');

    Route::prefix('hr')->group(function(){
        Route::prefix('employee')->as('employee.')->group(function(){
            Route::get('/', EmployeeList::class)->name('index');
            Route::get('/create', CreateEmployee::class)->name('create');
            Route::get('/edit/{id}', EditEmployee::class)->name('edit');
        });
    });

    Route::prefix('dms')->group(function(){

        Route::prefix('driver-types')->as('driver-types.')->group(function(){
            Route::get('/', DriverTypeList::class)->name('index');
            Route::get('/create', CreateDriverType::class)->name('create');
            Route::get('/edit/{id}', EditDriverType::class)->name('edit');
        });

        Route::prefix('drivers')->as('drivers.')->group(function(){
            Route::get('/', DriverList::class)->name('index');
            Route::get('/create', CreateDriver::class)->name('create');
            Route::get('/edit/{id}', EditDriver::class)->name('edit');
        });

        Route::prefix('businesses')->as('business.')->group(function(){
            Route::get('/', BusinessList::class)->name('index');
            Route::get('/create', CreateBusiness::class)->name('create');
            Route::get('/edit/{id}', EditBusiness::class)->name('edit');
        });
    });

});
