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
//Route::resource('/home', 'PortfolioController');

Route::get('/cmc', 'CoinMarketCapController@index');

Route::get('/coinDetails/{id}', 'PortfolioController@coinDetails');


Route::get('/find', 'CryptoCurrencyController@find');
