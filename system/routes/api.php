<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/hotline', 'API\get_request@get_hotline')->middleware('api');
Route::get('/info', 'API\get_request@get_info_category')->middleware('api');
Route::post('/get_details_tip', 'API\get_request@get_details')->middleware('api');
Route::post('/get_report', 'report_post@getReport')->middleware('api');
Route::post('/update_response', 'report_post@updateResponse')->middleware('api');
Route::post('/get_single_report', 'report_post@getSingleReport')->middleware('api');
Route::post('/addComment', 'report_post@addComment')->middleware('api');
Route::post('/getComment', 'report_post@getComment')->middleware('api');
Route::post('/getAction', 'report_post@getAction')->middleware('api');
Route::post('/free_officer', 'report_post@get_free_officer')->middleware('api');
Route::get('/assign_officer', 'report_post@assign_officer')->middleware('api');
Route::post('/add_action', 'report_post@update_action')->middleware('api');
Route::post('/get_simple_details', 'users@get_complaint_detail')->middleware('api');
Route::post('/get_own_report', 'users@get_own_report')->middleware('api');
Route::post('/get_followed_report', 'users@get_followed_report')->middleware('api');
Route::get('/test_send', 'users@test_send')->middleware('api');
Route::post('/notification', 'users@get_notification')->middleware('api');
Route::post('/fetchChatRoom', 'users@fetchChatRoom')->middleware('api');
Route::post('/fetchSingleChatRoom', 'users@fetchSingleChatRoom')->middleware('api');
Route::get('/touch_chat_room', 'users@touch_chat_room')->middleware('api');
Route::post('/addMessage', 'users@addMessage')->middleware('api');
Route::get('/unsolved_complaint', 'report_post@unsolved_complaint')->middleware('api');
Route::post('/query', 'users@query')->middleware('api');
Route::post('/searchUser', 'users@search_user')->middleware('api');
Route::post('/add_chat_user', 'users@addUser')->middleware('api');

Route::post('/login', 'users@login')->middleware('api');
Route::get('/report_type', 'report_type@getReportType')->middleware('api');
Route::post('/report_post', 'report_post@index')->middleware('api');
Route::post('/register', 'users@register_user')->middleware('api');
Route::put('/registerUserKey', 'users@register_key')->middleware('api');
Route::post('/add_avatar', 'users@addAvatar')->middleware('api');
Route::post('/search_user', 'users@search_user')->middleware('api');
Route::post('/get_user_report', 'users@getOwnReport')->middleware('api');

Route::get('/getMultiUser', 'users@getMultiUser')->middleware('api');
Route::post('/fetch_user_activity', 'users@get_Activity')->middleware('api');

Route::get('/testMessage', 'users@testMessage')->middleware('api');
