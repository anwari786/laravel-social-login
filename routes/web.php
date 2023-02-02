<?php

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
    return view('welcome');
});


Route::get('testslack', function () {

    // logger()->info('my first logger test message!');

    // logger()->channel('syslog')->alert("A test message to the system log of Appache!");

    logger()->channel('slack')->info('My first test message to Slack laravel channel from newly laravel application.');

    return "Weldone!";
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
