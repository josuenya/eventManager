<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers;

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

Route::middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {

    Route::get('/dashboard', [Controllers\EventsController::class, 'getEvent'])->name('dashboard');

    Route::get('/events', [Controllers\EventsController::class, 'getEvent'])->name('events.list');
    Route::get('/events/myEvents', [Controllers\EventsController::class, 'myEvents'])->name('events.myEvents');
    Route::post('/events/store',[Controllers\EventsController::class, 'store'])->name('event.store');
    Route::post('/events/update',[Controllers\EventsController::class, 'update'])->name('event.update');
    Route::post('/events/delete',[Controllers\EventsController::class, 'destroy']);
    Route::post('/events/range',[Controllers\EventsController::class, 'getEventByDate'])->name('events.range');
    Route::post('/events/filter',[Controllers\EventsController::class, 'filter'])->name('events.filter');
});

Route::get('/', [Controllers\EventsController::class, 'index'])->name('events');
