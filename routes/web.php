<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\DocumentManagementController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [UserController::class, 'index'])->name('users.index');

    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/document-management', [DocumentManagementController::class, 'index'])->name('document_management.index');

    Route::get('/branches/all', [BranchController::class, 'all']);
    Route::apiResource('branches', BranchController::class);

    Route::get('/departments/all', [DepartmentController::class, 'all']);
    Route::get('/get-department-by-branch/{branchId}', [DepartmentController::class, 'getDepartmentByBranch']);
    Route::apiResource('departments', DepartmentController::class);

    Route::get('/get-division-by-department/{departmentId}', [DivisionController::class, 'getDivisionByDepartment']);
    Route::apiResource('divisions', DivisionController::class);

    Route::get('/sections/all', [SectionController::class, 'all']);
    Route::get('/get-section-by-division-and-department', [SectionController::class, 'getSectionByDivisionAndDepartment']);
    Route::apiResource('sections', SectionController::class);

    Route::apiResource('folders', FolderController::class);

});
