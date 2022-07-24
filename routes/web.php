<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MembersImport;
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

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::middleware('can:isAdmin')->group(function () {
        Route::post('user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::resources([
            'user'      => UserController::class,
        ]);

        // Route::post('update/product/{id}', [ProductController::class, 'update'])->name('update.product');
    });
    Route::middleware('can:isHasAccess')->group(function () {
        Route::resources([
            'group'     => GroupController::class,
            'member'    => MemberController::class,
        ]);

        Route::post('import', function () {
            Excel::import(new MembersImport, request()->file('file'));
            return redirect()->back()->with('success','Data Imported Successfully');
        });
    });
});



Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('logout', [AuthController::class, 'logout'])->name('logout');
