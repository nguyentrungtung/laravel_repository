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

        Route::post('/set-permission','\App\Http\Controllers\Admin\User\UserController@setPermission' )->name('setPermission');
    });
    Route::group(['namespace' => 'Banner'], function () {
        Route::resource('banner', '\App\Http\Controllers\Admin\Banner\BannerController');
    });
    Route::group(['namespace' => 'RolePermission'] , function () {
        Route::resource('/rolepermission', '\App\Http\Controllers\Admin\RolePermission\RolePermissionController');
    });
    Route::group(['namespace' => 'Redirect'], function () {
        Route::resource('redirect', '\App\Http\Controllers\Admin\Redirect\RedirectController');
        Route::post('/remove-redirect', '\App\Http\Controllers\Admin\Redirect\RedirectController@removeAll')->name('redirect.removeAll');
        Route::post('update-redirect', '\App\Http\Controllers\Admin\Redirect\RedirectController@upgrate')->name('upgrate');
    });
    Route::group(['namespace' => 'Post'], function () {
        Route::resource('post', '\App\Http\Controllers\Admin\Post\PostController');
        route::post('/remove-post-all', '\App\Http\Controllers\Admin\Post\PostController@removeAll')->name('post.removeAll');
    });
    Route::group(['namespace' => 'PostCategory'], function () {
        Route::resource('postcategory', '\App\Http\Controllers\Admin\PostCategory\PostCategoryController');
    });
    Route::group(['namespace' => 'PostComment'], function () {
        Route::resource('postcomment', '\App\Http\Controllers\Admin\PostComment\PostCommentController');
    });

    Route::group(['namespace' => 'Media'], function () {
        Route::resource('media', '\App\Http\Controllers\Admin\Media\MediaController');
    });
});


Route::group(['namespace' => 'Admin'], function () {
    Route::group(['namespace' => 'Auth'], function () {
        Route::get('/admin/login', '\App\Http\Controllers\Admin\Auth\LoginController@showLoginForm')->name('login.get');
        Route::post('/admin/login', '\App\Http\Controllers\Admin\Auth\LoginController@authenticate')->name('login.post');
        Route::post('/admin/logout', '\App\Http\Controllers\Admin\Auth\LoginController@logout')->name('logout.post');
        // Route::get('/register','RegisterController@showRegistrationForm')->name('register.get');
        // Route::post('/register','RegisterController@registerAuth')->name('register.post');
    });
    Route::group(['namespace' => 'Demo'], function () {
        Route::resource('/demo', '\App\Http\Controllers\Admin\Demo\DemoController');
    });
    Route::group(['namespace' => 'Log'], function () {
        Route::resource('/log', '\App\Http\Controllers\Admin\Log\LogController');
    });
});


Route::get('/error', function () {
    return view('admin.errors.404');
})->name('404.error');


Route::get('/{any}', 'App\Http\Controllers\Admin\Redirect\RedirectController@redirect')->where('any', '.*');
