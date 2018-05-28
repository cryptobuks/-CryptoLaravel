<?php


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

$this->get('/verify-user/{code}', 'Auth\RegisterController@activateUser')->name('activate.user');
Route::group(['middleware' => ['auth']], function() {
  Route::resource('/home', 'PortfolioController');
  Route::get('/home', 'PortfolioController@index')->name('home');
  Route::post('/home', 'PortfolioController@store');
  Route::get('/coinDetails/{id}', 'PortfolioController@coinDetails');
  Route::get('/find', 'CryptoCurrencyController@find');
  Route::get('/edit/{id}', 'PortfolioController@edit');
});


Route::get('/cmc', 'CryptoDataController@cmc');
Route::get('/cc', 'CryptoDataController@cc');
Route::get('/chart', 'ChartsController@chart');
// Route::get('/test', function() {
//     return dd(Portfolio::testService());
// });
