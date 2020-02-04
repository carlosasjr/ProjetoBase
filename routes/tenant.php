<?php
Route::get('verify-domain', 'Tenant\CompanyController@verifyDomain');



Route::group(['namespace' => 'Tenant', 'middleware' => 'auth'], function () {

    Route::resource('companies', 'CompanyController');
    Route::resource('plans', 'PlanController');
    Route::post('delete-plan-detail', 'PlanController@destroyDetail');

    Route::get('paypal/generate', 'SubscriptionController@generatePlan')->name('paypal.generate');


    Route::get('/', 'TenantController@index')->name('tenants');
});



