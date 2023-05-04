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

Route::domain('photographer.'. env('APP_URL'))->group( function (){
    Route::get('/login', function (){
        return 'Second subdomain landing page';
    });
});

Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
