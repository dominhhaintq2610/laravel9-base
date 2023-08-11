<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserController;
use Inertia\Inertia;

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

//Route::get('/', [UserController::class, 'show']);
Route::get('/', function () {
    return Inertia::render('Home', [
        'name' => 'BlackFriday',
        'frameworks' => ['Laravel', 'Vue', 'Inertia']
    ]);
});

Route::get('/users', function () {
    sleep(3);
    return Inertia::render('Users');
});

Route::get('/settings', function () {
    return Inertia::render('Settings', [
        'time' => now()->toDateTimeString()
    ]);
});

Route::post('logout', function () {
    dd(request('foo'));
});
