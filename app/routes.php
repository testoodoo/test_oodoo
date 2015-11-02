<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

	Route::get('/oauth2callback', array('as' => 'index', 'uses' => 'ApiController@index'));
	Route::get('/send', array('as' => 'send', 'uses' => 'ApiController@createMessage'));
	Route::get('/list', array('as' => 'list', 'uses' => 'ApiController@listMessage'));
	Route::get('/update', array('as' => 'mail', 'uses' => 'ApiController@updateMessage'));
	Route::get('/show/{messageId}', array('as' => 'show', 'uses' => 'ApiController@showMessage'));	
	Route::post('/reply', array('as' => 'reply', 'uses' => 'ApiController@replyMessage'));
