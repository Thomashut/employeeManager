<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebControllers\DepartmentController;
use App\Http\Controllers\WebControllers\EmployeeController;
use App\Http\Controllers\WebControllers\EmployeeAuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [EmployeeController::class, 'index']);
Route::get('/login', [EmployeeAuthController::class, 'login'])->withoutMiddleware('auth');
Route::post('/login', [EmployeeAuthController::class, 'login'])->withoutMiddleware('auth')->name('login');
Route::get('/logout', [EmployeeAuthController::class, 'logout']);
Route::post('/logout', [EmployeeAuthController::class, 'logout']);
Route::get('/dashboard', [EmployeeAuthController::class, 'dashboard'])->name('dashboard');

Route::prefix('employee')->group(function() {
    Route::get('/list', [EmployeeController::class, 'index'])->name('employee');
    Route::Get('/restoreList', [EmployeeController::class, 'restoreIndex']);
    Route::get('/create', [EmployeeController::class, 'create']);
    Route::get('/edit/{id}', [EmployeeController::class, 'edit']);
    Route::post('/save', [EmployeeController::class, 'store']);
    Route::put('/update/{id}', [EmployeeController::class, 'update']);
    Route::delete('/delete/{id}', [EmployeeController::class, 'destroy']);
    Route::get('/restore/{id}', [EmployeeController::class, 'restore']);
});

Route::prefix('department')->group(function() {
    Route::get('/list', [DepartmentController::class, 'index'])->name('department');
    Route::get('/create', [DepartmentController::class, 'create']);
    Route::get('/edit/{id}', [DepartmentController::class, 'edit']);
    Route::post('/save', [DepartmentController::class, 'store']);
    Route::put('/update/{id}', [DepartmentController::class, 'update']);
    Route::delete('/delete/{id}', [DepartmentController::class, 'destroy']);
    Route::get('/restore/{id}', [DepartmentController::class, 'restore']);
});