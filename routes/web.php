<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApisController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware'=>'auth'], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan');
    Route::get('/api/karyawan/getdata', [KaryawanController::class, 'getdata']);
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::get('/karyawan/detail/{id}', [KaryawanController::class, 'show']);
    Route::get('/karyawan/edit/{id}', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/update/{id}', [KaryawanController::class, 'update']);


    
    Route::get('/users', [UsersController::class, 'index'])->name('users');
    Route::get('/users/create', [UsersController::class, 'create']);
    Route::get('/users/edit/{id}', [UsersController::class, 'edit']);
    Route::get('/api/edit/{id}', [UsersController::class, 'edittable']);
    Route::post('/users/store', [UsersController::class, 'store']);
    Route::post('/users/update/{id}', [UsersController::class, 'update']);
    Route::post('/users/delete/{id}', [ApisController::class, 'apideleteuserbyid']);
    Route::get('/api/usersaccess/{id}', [ApisController::class, 'apiGetDataUserAccessById']);
    Route::get('/api/usersaccess2/{id}', [ApisController::class, 'apiGetDataUserAccessById2']);
    Route::get('/api/users/getdata', [ApisController::class, 'apigetdatauser']);
    Route::get('/api/users/getdatabyid/{id}', [ApisController::class, 'apigetdatauserbyid']);
    Route::get('/api/getdivision', [ApisController::class, 'apigetdivisi']);
    Route::get('/api/getrole', [ApisController::class, 'apigetrole']);
    Route::get('/ api/getgud', [ApisController::class, 'apigetgud']);
    Route::get('/api/tablegudang/getdata/{id}', [UsersController::class, 'tableGudang']);
    

    
});
Route::get('/404', [R404Controller::class, 'r404']);
Route::get('/405', [R404Controller::class, 'r405']);
Route::get('/500', [R404Controller::class, 'r500']);

require __DIR__.'/auth.php';

