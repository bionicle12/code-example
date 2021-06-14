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


Auth::routes([
    'register' => false,
    'reset' => false,
    'verify' => false,
]);

//Route::view('/', 'welcome');

Route::middleware('auth')
    ->group(function () {
        Route::view('/', 'admin.app');

        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
            ->name('home');

        //Locale
        Route::get('/locales', [App\Http\Controllers\Locale\LocaleController::class, 'index'])
            ->name('locales.index');
        Route::get('/locales/create', [App\Http\Controllers\Locale\LocaleController::class, 'create'])
            ->name('locales.create');
        Route::post('/locales', [App\Http\Controllers\Locale\LocaleController::class, 'store'])
            ->name('locales.store');

        // Page
        Route::get('/pages', [App\Http\Controllers\Page\PageController::class, 'index'])
            ->name('pages.index');
        Route::post('/pages', [App\Http\Controllers\Page\PageController::class, 'store'])
            ->name('pages.store');
        Route::get('/pages/create', [App\Http\Controllers\Page\PageController::class, 'create'])
            ->name('pages.create');
        Route::get('/pages/{page}/edit', [App\Http\Controllers\Page\PageController::class, 'edit'])
            ->name('pages.edit');
        Route::delete('/pages/{page}', [App\Http\Controllers\Page\PageController::class, 'destroy'])
            ->name('pages.destroy');
        Route::patch('/pages/{page}', [App\Http\Controllers\Page\PageController::class, 'update'])
            ->name('pages.update');
    });

Route::get('/test', [App\Http\Controllers\Test\TestController::class, 'index']);
