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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/logout', 'Auth\LoginController@logout');

Route::group(['middleware' => ['web', 'auth']], function() {
  Route::resource('report','Web\ApproveHandler', ['except' => ['show']]);
  Route::get('/dashboard','Web\DashboardController@index')->name('dashboard.index');
  Route::get('/dashboard/filter', 'Web\DashboardController@filter')->name('dashboard.filter');
  Route::any('/dashboard/automail', 'Web\DashboardController@send');
  Route::resource('emergency_contact', 'Web\EmergencyContact', ['except' => ['show']]);
  Route::resource('safety_tip', 'Web\SafetyTipsController', ['except' => ['show']]);
  Route::get('/tip_details/{id}', 'Web\TipDetailsController@index')->name('tip_category.index');
  Route::get('/tip_details/{id}/create', 'Web\TipDetailsController@create')->name('tip_category.create');
  Route::post('/tip_details/{id}', 'Web\TipDetailsController@store')->name('tip_category.store');
  Route::get('/tip_details/{id}/edit', 'Web\TipDetailsController@edit')->name('tip_category.edit');
  Route::patch('/tip_details/{id}/update', 'Web\TipDetailsController@update')->name('tip_category.update');
  Route::delete('/tip_details/{id}', 'Web\TipDetailsController@destroy')->name('tip_category.destroy');
  Route::resource('report_types', 'Web\ReportTypeController', ['except' => ['show']]);
  Route::resource('apps_user', 'Web\AppUserController', ['except' => ['edit']]);
  Route::get('/select_mail', 'Web\DashboardController@report')->name('email.select');
  Route::get('/mail/send', 'Web\DashboardController@send')->name('email.send');
  Route::post('/complaint/assign_officer/{id}', 'Web\ApproveHandler@officer')->name('officer');
  Route::post('/complaint/new_action/{id}', 'Web\ApproveHandler@action')->name('action');
  Route::get('/report/query', 'Web\ApproveHandler@query')->name('query');
  Route::get('/dummy_test', 'Web\DashboardController@dummy')->name('dummy');
});