<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:api')->group(function(){

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/pages', 'App\Http\Controllers\Page\PageController@index');
    Route::post('/pages', 'App\Http\Controllers\Page\PageController@store');
    Route::get('/pages/{page}', 'App\Http\Controllers\Page\PageController@edit');
    Route::delete('/pages/{page}', 'App\Http\Controllers\Page\PageController@destroy');
    Route::patch('/pages/{page}', 'App\Http\Controllers\Page\PageController@update');

    Route::get('/locales', 'App\Http\Controllers\Locale\LocaleController@index');
    Route::get('/locales/active', 'App\Http\Controllers\Locale\LocaleController@activeLocales');
    Route::get('/locales/{id}', 'App\Http\Controllers\Locale\LocaleController@edit');
    Route::patch('/locales/{id}', 'App\Http\Controllers\Locale\LocaleController@update');
    Route::post('/locales', 'App\Http\Controllers\Locale\LocaleController@store');

    Route::get('/hmenu', 'App\Http\Controllers\HMenu\HMenuController@index');
    Route::get('/hmenu/list', 'App\Http\Controllers\HMenu\HMenuController@list');
    Route::get('/hmenu/active', 'App\Http\Controllers\HMenu\HMenuController@activeMenu');
    Route::get('/hmenu/{id}', 'App\Http\Controllers\HMenu\HMenuController@edit');
    Route::post('/hmenu', 'App\Http\Controllers\HMenu\HMenuController@store');
    Route::patch('/hmenu/{id}', 'App\Http\Controllers\HMenu\HMenuController@update');
    Route::delete('/hmenu/{id}', 'App\Http\Controllers\HMenu\HMenuController@destroy');

});
