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

//Route::get('/', function () {
//    return view('welcome');
//});


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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => 'web'], function () {
    Route::group(['middleware' => 'auth'], function() {
        Route::group(['namespace' => 'Home'], function () {
            Route::resource('/home', '\App\Http\Controllers\Admin\Home\HomeController');
        });
    });

    Route::group(['namespace' => 'Lang'], function () {
        Route::get('lang/{lang}', '\App\Http\Controllers\Admin\Lang\LangController@changeLang')->name('lang');
    });

    Route::group(['namespace' => 'User'], function () {
        Route::resource('/user', '\App\Http\Controllers\Admin\User\UserController');
        Route::get('/profile/{id}', '\App\Http\Controllers\Admin\User\UserController@profileUser')->Name('profile');
    });
});


Route::group(['namespace' => 'Admin'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/login', '\App\Http\Controllers\Admin\Auth\LoginController@showLoginForm')->name('login.get');
        Route::post('/login', '\App\Http\Controllers\Admin\Auth\LoginController@authenticate')->name('login.post');
        Route::post('/logout', '\App\Http\Controllers\Admin\Auth\LoginController@logout')->name('logout.post');
        // Route::get('/register','RegisterController@showRegistrationForm')->name('register.get');
        // Route::post('/register','RegisterController@registerAuth')->name('register.post');
    });
});

Route::get('/error', function () {
    return view('admin.errors.404');
})->name('404.error');


