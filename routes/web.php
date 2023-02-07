<?php

use App\Http\Controllers\FileuploadController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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


Route::get('auth/{provider}', [LoginController::class, 'redirectToProvider'])->name('to_provider');

Route::get('auth/{provider}/callback', [LoginController::class, 'handleProviderCallback']);

// show file upload form
Route::get('/fileupload', [FileuploadController::class, 'create'])->name('fileupload_create');

// File upload and store action
Route::post('/fileupload', [FileuploadController::class, 'store'])->name('fileupload_store');

// Test sending mails
Route::get('testmail', [HomeController::class, 'sendTestMail'])->name('testmail');
Route::get('markdowntestmail', [HomeController::class, 'sendMarkdownTestMail'])->name('markdowntestmail');