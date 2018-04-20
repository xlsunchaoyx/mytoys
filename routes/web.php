<?php

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

Route::get('/', 'ExcelController@index');
Route::post('/', 'ExcelController@store');

Route::get('/step2', 'ExcelController@index2');
Route::post('/step2', 'ExcelController@store2');


