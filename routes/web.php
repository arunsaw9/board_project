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

use App\User;
use App\BoardAgenda;
use App\CommitteeAgenda;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return BoardAgenda::first()->audits;
// });


Route::get('/', 'HomeController@index');
Route::get('/test', 'HomeController@test');

// Auth::routes();

Route::get('/login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('/login', 'Auth\LoginController@getOtp');
Route::patch('/login', 'Auth\LoginController@login')->middleware('decode');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/auth/check', 'Auth\LoginController@authCheck');

Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/token', 'HomeController@token');
Route::get('/logs', 'HomeController@logs')->middleware('auth');

Route::get('/board/home', 'HomeController@board');
Route::get('/board/home/{tab}', 'HomeController@board');
Route::get('/board/agenda/uid/{category}/{type}', 'BoardAgendaController@uidGen');

Route::get('/board/agenda/{id}/{document}/view', 'BoardAgendaController@view');
Route::delete('/board/agenda/{id}/{document}', 'BoardAgendaController@deleteDocument')->middleware('restrict:admin');
Route::resource('/board/agenda', 'BoardAgendaController');

Route::get('/board/meeting/admin', 'BoardMeetingController@admin')->middleware('restrict:admin');
Route::get('/board/meeting/admin/{tab}', 'BoardMeetingController@admin')->middleware('restrict:admin');
Route::get('/board/meeting/archive', 'BoardMeetingController@archive')->middleware('restrict:admin,user');
Route::post('/board/meeting/users', 'BoardMeetingController@users')->middleware('restrict:admin');
Route::post('/board/meeting/filter', 'BoardMeetingController@filter');
Route::resource('/board/meeting', 'BoardMeetingController');
Route::post('/board/meeting/action/{action}', 'BoardMeetingController@action')->middleware('restrict:admin');

Route::get('/committee/home/{id}', 'HomeController@committee');
Route::get('/committee/agenda/{id}/{document}/view', 'CommitteeAgendaController@view');
Route::delete('/committee/agenda/{id}/{document}', 'CommitteeAgendaController@deleteDocument')->middleware('restrict:admin');
Route::post('/committee/agenda/copy', 'CommitteeAgendaController@copy')->middleware('restrict:admin');
Route::resource('/committee/agenda', 'CommitteeAgendaController');

Route::get('/committee/meeting/user/{id}', 'CommitteeMeetingController@indexSheet');
Route::post('/committee/meeting/action/{action}', 'CommitteeMeetingController@action')->middleware('restrict:admin');
Route::post('/committee/meeting/{id}/filter', 'CommitteeMeetingController@filter')->middleware('restrict:admin,user');
Route::get('/committee/meeting/{id}/users', 'CommitteeMeetingController@users')->middleware('restrict:admin');
Route::post('/committee/meeting/{id}/users', 'CommitteeMeetingController@addUsers')->middleware('restrict:admin');
Route::resource('/committee/meeting', 'CommitteeMeetingController');

Route::post('/user/{id}/agenda', 'UserController@agenda')->middleware('restrict:admin');
Route::patch('/user/{id}/reset', 'UserController@reset')->middleware('decode')->middleware('restrict:admin');
Route::resource('/user', 'UserController');

Route::resource('/notification', 'NotificationController');

Route::get('/archive/board', 'BoardMeetingController@archive')->middleware('restrict:admin,user');
Route::get('/archive/committee', 'ArchiveController@index')->middleware('restrict:admin,user');
Route::resource('/archive', 'ArchiveController');

Route::get('/annotate/{portal}/{id}/{doc}', 'AnnotationController@get')->middleware('auth');
Route::post('/annotate/{portal}/{id}/{doc}', 'AnnotationController@post')->middleware('auth');;

Route::resource('/query', 'QueryController')->middleware('auth');;

Route::get('/viewer/board/{id}/{document}', 'WebviewerController@board')->middleware('auth');;
Route::get('/viewer/committee/{id}/{document}', 'WebviewerController@committee')->middleware('auth');

Route::get('/watermark/{portal}/{agenda}/{document}', 'WebviewerController@watermark')->middleware('auth');