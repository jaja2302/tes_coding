<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InputController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PertandinganController;
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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/data', [InputController::class, 'index'])->name('data');
Route::get('/', [DashboardController::class, 'index'])->name('dahsboard');
Route::get('/tanding', [PertandinganController::class, 'index'])->name('tanding');
