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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('kirim','EmailController@index');

Route::get('/', 'Frontend\PageController@landing')->name('landing');
Route::get('/about', 'Frontend\PageController@pageAbout')->name('page.about');
Route::get('/smart-order', 'Frontend\SmartOrderController@index')->name('smart-order.index');
Route::post('/smart-order', 'Frontend\SmartOrderController@process')->name('smart-order.process');
Route::post('/package/detail', 'Frontend\SmartOrderController@detailPackage')->name('pg.detail');
Route::get('/checkout/{id}', 'Frontend\PageController@checkout')->name('page.checkout')->middleware('auth');
Route::post('/checkout', 'Frontend\PageController@checkoutStore')->name('page.checkout.store')->middleware('auth');

Auth::routes();

Route::post('/login', 'Auth\LoginController@login')->middleware('checkstatus');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/account/profile', 'ProfileController@show')->name('profile.show');
Route::put('/account/profile', 'ProfileController@update')->name('profile.update');
Route::put('/account/profile/member', 'ProfileController@updateMember')->name('profile.update.member');

Route::group(['prefix' => 'main', 'middleware' => ['auth', 'role:admin']], function () {
    Route::get('user', 'Backend\UserController@index' )->name('user.index');
    Route::post('user', 'Backend\UserController@store' )->name('user.store');
    Route::get('user/create', 'Backend\UserController@create' )->name('user.create');
    Route::get('user/{id}/edit', 'Backend\UserController@edit' )->name('user.edit');
    Route::put('user/{id}/update', 'Backend\UserController@update' )->name('user.update');
    Route::delete('user/{id}', 'Backend\UserController@destroy' )->name('user.destroy');
    Route::delete('user/{id}/update_status', 'Backend\UserController@update_status' )->name('user.update_status');
    

    Route::resource('package', 'Backend\PackageController');
    Route::resource('order', 'Backend\OrderController');
    Route::resource('payment', 'Backend\PaymentController');

    Route::resource('criteria', 'Backend\CriteriaController');
    Route::resource('alternative-criteria', 'Backend\AlternativeCriteriaController');
    Route::delete('alternative-criteria/{id}/update_status', 'Backend\AlternativeCriteriaController@update_status' )->name('alternative-criteria.update_status');

    Route::resource('announcement', 'Backend\AnnouncementController');
});

Route::group(['prefix' => 'member', 'middleware' => ['auth', 'role:member']], function () {
    Route::get('/transaction/{id}/cancel', 'Frontend\TransactionController@cancel')->name('transaction.cancel');
    Route::resource('transaction', 'Frontend\TransactionController');
    Route::resource('jamaah', 'Frontend\MemberController');
});