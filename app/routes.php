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

Route::get('/', function()
{
	return View::make('hello');
});


// Please add your routes to the most appropriate group below. "name" is my own experimentation; may switch that to prefix later
Route::group(array('name'=>'simple'), function(){

});

Route::group(array('name'=>'intermediate'), function(){

});

Route::group(array('name'=>'advanced'), function(){

});