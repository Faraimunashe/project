<?php

use App\Http\Controllers\ProfileController;
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
    return redirect()->route('login');
});

Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/admin/dashboard', 'App\Http\Controllers\admin\DashboardController@index')->name('admin-dashboard');

    Route::get('/admin/employees', 'App\Http\Controllers\admin\EmployeeController@index')->name('admin-employees');
    Route::post('/admin/add-employee', 'App\Http\Controllers\admin\EmployeeController@add')->name('admin-add-employee');
    Route::post('/admin/update-employee', 'App\Http\Controllers\admin\EmployeeController@update')->name('admin-update-employee');
    Route::post('/admin/delete-employee', 'App\Http\Controllers\admin\EmployeeController@delete')->name('admin-delete-employee');

    Route::get('/admin/projects', 'App\Http\Controllers\admin\ProjectController@index')->name('admin-projects');
    Route::post('/admin/add-project', 'App\Http\Controllers\admin\ProjectController@add')->name('admin-add-project');
    Route::post('/admin/update-project', 'App\Http\Controllers\admin\ProjectController@update')->name('admin-update-project');
    Route::post('/admin/delete-project', 'App\Http\Controllers\admin\ProjectController@delete')->name('admin-delete-project');

    Route::get('/admin/project/{project_id}', 'App\Http\Controllers\admin\ProjectController@see')->name('admin-see-project');

    Route::post('/admin/add-risk', 'App\Http\Controllers\admin\ProjectController@add_risk')->name('admin-add-risk');
    Route::post('/admin/add-activity', 'App\Http\Controllers\admin\ProjectController@add_activity')->name('admin-add-activity');
    Route::post('/admin/add-requirement', 'App\Http\Controllers\admin\ProjectController@add_requirement')->name('admin-add-requirement');
});


Route::group(['middleware' => ['auth', 'role:user']], function () {
    Route::get('/user/dashboard', 'App\Http\Controllers\user\DashboardController@index')->name('user-dashboard');
});

require __DIR__.'/auth.php';
