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
Route::resource('/home', 'PortfolioController');

Route::get('/home', 'PortfolioController@index')->name('home');

$this->get('/verify-user/{code}', 'Auth\RegisterController@activateUser')->name('activate.user');

Route::post('/home', 'PortfolioController@store');

Route::get('/coinDetails/{id}', 'PortfolioController@coinDetails');
Route::get('/find', 'CryptoCurrencyController@find');


Route::get('/cmc', 'CryptoDataController@cmc');
Route::get('/cc', 'CryptoDataController@cc');
Route::get('/chart', 'ChartsController@chart');
Route::get('/test', function() {
    return dd(Portfolio::testService());
});
