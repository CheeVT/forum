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

use Illuminate\Support\Facades\Redis;

Route::get('/', function () {
    /*$visit = Redis::incr('visits');

    echo $visit;*/
    return redirect('/login');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads', 'ThreadsController@index')->name('threads.index');
Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('/threads/{board}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::post('/threads', 'ThreadsController@store')->name('threads.store')->middleware('must-be-verified');
Route::get('/threads/{board}', 'ThreadsController@index')->name('threads.board');
Route::get('/threads/{board}/{thread}/replies', 'RepliesController@index')->name('replies.index');
Route::post('/threads/{board}/{thread}/replies', 'RepliesController@store')->name('replies.store')->middleware('auth');
Route::delete('/threads/{board}/{thread}', 'ThreadsController@destroy')->name('threads.destroy');
Route::post('/threads/{board}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->name('thread-subscriptions.store')->middleware('auth');
Route::delete('/threads/{board}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->name('thread-subscriptions.destroy')->middleware('auth');

Route::post('/locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('favorites.store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy')->name('favorites.destroy');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');
Route::patch('/replies/{reply}', 'RepliesController@update')->name('replies.update');

Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profiles.show');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index')->name('user-notifications.index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy')->name('user-notifications.destroy');

Route::get('/api/users', 'Api\UsersController@index')->name('api.users.index');
Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store')->name('api.users-avatar.store');