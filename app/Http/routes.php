<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

# Auth and web providers
Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'AngularController@serveApp');
    Route::get('/unsupported-browser', 'AngularController@unsupported');
    Route::get('user/verify/{verificationCode}', ['uses' => 'Auth\AuthController@verifyUserEmail']);
    Route::get('auth/{provider}', ['uses' => 'Auth\AuthController@redirectToProvider']);
    Route::get('auth/{provider}/callback', ['uses' => 'Auth\AuthController@handleProviderCallback']);
    Route::get('/api/authenticate/user', 'Auth\AuthController@getAuthenticatedUser');

});

# Invoices
Route::group(['prefix' => 'invoices'], function () {

  Route::post('list', 'InvoicesController@getList');
  Route::post('create', 'InvoicesController@postCreate');
  Route::post('view', 'InvoicesController@getInvoiceById');
  Route::post('edit', 'InvoicesController@editInvoiceById');

});
Route::resource('invoices', 'InvoicesController');

# Enterprises
Route::group(['prefix' => 'enterprises'], function () {

  Route::post('list', 'EnterprisesController@getList');

});
Route::resource('enterprises', 'EnterprisesController');

# Clients
Route::group(['prefix' => 'clients'], function () {

  Route::post('list', 'ClientsController@getList');

});
Route::resource('clients', 'ClientsController');

$api->group(['middleware' => ['api']], function ($api) {
    $api->controller('auth', 'Auth\AuthController');

    // Password Reset Routes...
    $api->post('auth/password/email', 'Auth\PasswordResetController@sendResetLinkEmail');
    $api->get('auth/password/verify', 'Auth\PasswordResetController@verify');
    $api->post('auth/password/reset', 'Auth\PasswordResetController@reset');
});

$api->group(['middleware' => ['api', 'api.auth']], function ($api) {
    $api->get('users/me', 'UserController@getMe');
    $api->put('users/me', 'UserController@putMe');
});

$api->group(['middleware' => ['api', 'api.auth', 'role:admin.super|admin.user']], function ($api) {
    $api->controller('users', 'UserController');
});
