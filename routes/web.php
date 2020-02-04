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


Route::view('/404-tenant', 'erros.404-tenant')->name('404.tenant');

//Login
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Password Reset Routes...
Route::post('password/email', 'auth\forgotpasswordcontroller@sendresetlinkemail')->name('password.email');
Route::get('password/reset', 'auth\forgotpasswordcontroller@showlinkrequestform')->name('password.request');
Route::post('password/reset', 'auth\resetpasswordcontroller@reset')->name('password.reseting');
Route::get('password/reset/{token}', 'auth\resetpasswordcontroller@showresetform')->name('password.reset');

// Registration Routes...
Route::group(['middleware' => ['auth', 'not.domain.main']], function () {
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register')->name('');
});

//Choose a Plan
Route::get('plans/choosePlan',
    'Tenant\PlanController@choosePlan')->middleware('not.domain.main')->name('plans.choosePlan');

//Paypal routes
Route::group(['namespace' => 'Tenant', 'middleware' => 'auth'], function () {

    Route::get('paypal/create/{id}', 'SubscriptionController@createPlan')->name('paypal.create');
    Route::get('paypal/list', 'SubscriptionController@listPlan')->name('paypal.list');
    Route::get('paypal/{id}', 'SubscriptionController@showPlan');
    Route::get('paypal/{id}/activate', 'SubscriptionController@activatePlan');
    Route::get('paypal/{id}/detail', 'PayPalController@detailAgreement');
});

//Public Route for Paypal
route::get('paypal/{companyUuid}/{paypalID}',
    'Tenant\PayPalController@createAgreement')->name('paypal.agreement')->middleware('not.domain.main');

route::get('return-paypal', 'Tenant\PayPalController@returnPayPal')->name('return.paypal');


//Register public Company
Route::post('register-company', 'IndexController@register')->name('register');

//Sistems Routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
});


Route::get('/', 'IndexController@index')->name('index');
