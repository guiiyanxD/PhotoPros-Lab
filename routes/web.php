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

/*Route::domain('photographer.'. env('APP_URL'))->group( function (){
    Route::get('login', function (){
        return 'Second subdomain landing page';
    });
});*/





Route::get('/', function () {
    return view('welcome');
})->name('welcome')->middleware('guest');

Auth::routes();

Route::get('/home', 'UserController@index')->name('home');
Route::get('/register/ph', [\App\Http\Controllers\Auth\RegisterController::class,'registerPh'])
    ->name('registerph.view');
Route::get('/become/ph', [\App\Http\Controllers\Auth\RegisterController::class,'becomePh'])
    ->name('becomeph.view');
Route::get('photographer/home', 'PhController@index')
    ->name('photographer.home');

Route::get('upload/profile-picture',[\App\Http\Controllers\UserController::class,'uploadImageView'])
    ->name('user.upload_profile_picture.view');
Route::post('upload/profile-picture/doing',[\App\Http\Controllers\UserController::class,'uploadImage'])
->name('user.upload_profile_picture');

Route::get('/ph/hire', [\App\Http\Controllers\PhController::class,'hire'])
    ->name('ph.hire');



Route::get('/events', 'EventController@index')
    ->name('event.index');
Route::get('/events/create', 'EventController@create')
    ->name('event.create');
Route::post('/events/store',[\App\Http\Controllers\EventController::class,'store'])
    ->name('event.store');
/*Route::post('/events/join', [\App\Http\Controllers\EventController::class,'addAttendantByCodeInvitation'])
    ->name('event.join');*/
Route::post('/events/join', [\App\Http\Controllers\EventController::class,'addAttendantByCodeInvitation'])
    ->name('event.join');
Route::get('/events/show/host/{id}', [\App\Http\Controllers\EventController::class,'showEventifHost'])
    ->name('event.show.host');
Route::get('/events/show/{id}', [\App\Http\Controllers\EventController::class,'showEventifAssistant'])
    ->name('event.show.attendant');


//Route::get('aux/ph/profile', [\App\Http\Controllers\PhController::class,'updateNoProfilePicture']);
