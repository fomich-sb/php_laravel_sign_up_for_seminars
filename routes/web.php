<?php

use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Route;

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

Route::get('/admin', [RouteController::class, 'adminAction'])
    ->name('game.admin');

Route::get('/admin/{controllerName}', [RouteController::class, 'adminAction'])
    ->name('game.admin.index');

Route::get('/admin/{controllerName}/{action}', [RouteController::class, 'adminAction'])
    ->name('game.admin.action');

Route::post('/admin/{controllerName}/{action}', [RouteController::class, 'adminAction'])
    ->name('game.admin.action');

Route::post('/admin/{controllerName}/{action}', [RouteController::class, 'adminAction'])
    ->name('game.admin.action');


Route::get('/{controllerName}', [RouteController::class, 'action'])
    ->name('game.index');

Route::get('/login', [RouteController::class, 'login'])
    ->name('game.login');

Route::get('/{controllerName}/{action}', [RouteController::class, 'action'])
    ->name('game.action');

Route::post('/{controllerName}/{action}', [RouteController::class, 'actionPost'])
    ->name('game.actionPost');
    
Route::post('/{controllerName}/{action}', [RouteController::class, 'actionPost'])
        ->name('game.actionPost');


Route::get('/', [RouteController::class, 'action'])->name('root');
