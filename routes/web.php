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

Route::get('/','AuthController@index');
/*Route::get('/home','HomeController@getHome')->name('home'); */ 
//crea y guarda un nuevo evento en la bdd.
// Rutas de login 
Route::get('/google-callback','AuthController@index');

// Rutas especiales para el CRUD. 
Route::get('/geteventosCalendarPrimary','EventController@getEventsPrimary');
Route::post('/saveEventInGoogleCalendar','EventController@saveEventInGoogleCalendar');
Route::post('/editEventInGoogleCalendar ','EventController@editEventInGoogleCalendar');
Route::post('/deleteEventInGoogleCalendar ','EventController@deleteEventInGoogleCalendar');
//Inicio vista.
Route::get('/logout','AuthController@logout');

