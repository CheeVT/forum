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

/*Route::get('/', function () {
    return view('welcome');
});*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/threads', 'ThreadsController@index')->name('threads.index');
Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('/threads/{board}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::post('/threads', 'ThreadsController@store')->name('threads.store');
Route::get('/threads/{board}', 'ThreadsController@index')->name('threads.board');
Route::get('/threads/{board}/{thread}/replies', 'RepliesController@index')->name('replies.index');
Route::post('/threads/{thread}/replies', 'RepliesController@store')->name('replies.store')->middleware('auth');
Route::delete('/threads/{board}/{thread}', 'ThreadsController@destroy')->name('threads.destroy');
Route::post('/threads/{board}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->name('thread-subscriptions.store')->middleware('auth');
Route::delete('/threads/{board}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->name('thread-subscriptions.destroy')->middleware('auth');

Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('favorites.store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy')->name('favorites.destroy');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('replies.destroy');
Route::patch('/replies/{reply}', 'RepliesController@update')->name('replies.update');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profiles.show');