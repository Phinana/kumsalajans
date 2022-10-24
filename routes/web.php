<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\kumsalajansController;

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

Route::get('/', [kumsalajansController::class, 'index'])->name("show.index");
Route::post('/getTasks', [kumsalajansController::class, 'getTasks'])->name("show.getTasks");
Route::post('/addTask', [kumsalajansController::class, 'addTask'])->name("show.addTask");
Route::post('/deleteTask', [kumsalajansController::class, 'deleteTask'])->name("show.deleteTask");
Route::post('/editTask', [kumsalajansController::class, 'editTask'])->name("show.editTask");
Route::post('/searchTask', [kumsalajansController::class, 'searchTask'])->name("show.searchTask");
