<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\UnitsOfWork\Interfaces\IDepartmentUOW;
use App\UnitsOfWork\Interfaces\IEmployeeUOW;
use App\UnitsOfWork\DepartmentUOW;
use App\UnitsOfWork\EmployeeUOW;

/**
 * This provider will handle injecting UOW's into the Laravel Service container
 */
class EmployeeManagerProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(IDepartmentUOW::class, DepartmentUOW::class);
        $this->app->bind(IEmployeeUOW::Class, EmployeeUOW::class);
    }
}
