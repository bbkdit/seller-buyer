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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/userlist', function(){
	return view('userlist');
});
Route::post('/serverSideSeller', [
    'as'   => 'serverSide',
    'uses' => function () {
        $users = App\User::where('user_type',1)->get();
        return DataTables::of($users)->make();
    }
]);

Route::post('/serverSideBuyer', [
    'as'   => 'serverSide',
    'uses' => function () {
        $users = App\User::where('user_type',2)->get();
        return DataTables::of($users)->make();
    }
]);

