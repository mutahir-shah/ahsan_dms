<?php

namespace App\Providers;

use App\Interfaces\{AuthInterface, BranchInterface, CountryInterface, DepartmentInterface, DesignationInterface, EmployeeInterface, EmploymentTypeInterface, LanguageInterface, RoleInterface};
use App\Repositories\{AuthRepository, BranchRepository, CountryRepository, DepartmentRepository, DesignationRepository, EmployeeRepository, EmploymentTypeRepository, LanguageRepository, RoleRepository};
use App\Services\{AuthService, BranchService, CountryService, DepartmentService, DesignationService, EmployeeService, EmploymentTypeService, LanguageService, RoleService};

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Auth Reposirtoy
        $this->app->bind(AuthInterface::class, AuthRepository::class);
        $this->app->bind(AuthService::class, function($app){
            return new AuthService($app->make(AuthInterface::class));
        });

        // Employee Repository
        $this->app->bind(EmployeeInterface::class, EmployeeRepository::class);
        $this->app->bind(EmployeeService::class, function($app){
            return new EmployeeService($app->make(EmployeeInterface::class));
        });

        // Branch Repository
        $this->app->bind(BranchInterface::class, BranchRepository::class);
        $this->app->bind(BranchService::class, function($app){
            return new BranchService($app->make(BranchInterface::class));
        });

        // Designation Repository
        $this->app->bind(DesignationInterface::class, DesignationRepository::class);
        $this->app->bind(DesignationService::class, function($app){
            return new DesignationService($app->make(DesignationInterface::class));
        });

        // Department Repository
        $this->app->bind(DepartmentInterface::class, DepartmentRepository::class);
        $this->app->bind(DepartmentService::class, function($app){
            return new DepartmentService($app->make(DepartmentInterface::class));
        });

        // Role Repository
        $this->app->bind(RoleInterface::class, RoleRepository::class);
        $this->app->bind(RoleService::class, function($app){
            return new RoleService($app->make(RoleInterface::class));
        });

        // EmploymentType Repository
        $this->app->bind(EmploymentTypeInterface::class, EmploymentTypeRepository::class);
        $this->app->bind(EmploymentTypeService::class, function($app){
            return new EmploymentTypeService($app->make(EmploymentTypeInterface::class));
        });

        // Country Repository
        $this->app->bind(CountryInterface::class, CountryRepository::class);
        $this->app->bind(CountryService::class, function($app){
            return new CountryService($app->make(CountryInterface::class));
        });

        // Language Repository
        $this->app->bind(LanguageInterface::class, LanguageRepository::class);
        $this->app->bind(LanguageService::class, function($app){
            return new LanguageService($app->make(LanguageInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('translate', function ($keyword) {
            return "<?php echo translate($keyword); ?>";
        });
    }
}
