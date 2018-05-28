<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Session;
use Redirect;
use App\Portfolio;
use App\CryptoCurrency;
use App\Http\Requests\CoinRequest;
use App\Repositories\Portfolio\PortfolioRepository;

class PortfolioController extends Controller
{
  protected $model;

   public function __construct(Portfolio $portfolio)
   {
       // set the model
       $this->model = new PortfolioRepository($portfolio);
   }

    public function index() {
      return View::make('home')->with([
        'coins' => $this->model->getCoinTotalAmount(),
        'portfolio' => $this->model->getAll(),
        'initialPortfolioValue' => $this->model->calculateInitialPortfolioValue(),
        'totalMarketValue' => $this->model->calculateTotalMarketValue(),
        'returnOfInvestment' => $this->model->getReturnOfInvestment()->value,
        'returnOfInvestmentPercentage' => $this->model->getReturnOfInvestment()->percentage,
        'chart' => $this->model->createChart()
      ]);
    }

    public function edit($id) {
      return View::make('portfolio.edit')->with('portfolio', $this->model->find($id));
    }

    public function update(CoinRequest $request, $id) {
      $this->model->update($request, $id);
      Session::flash('message', 'Successfully Updated Portfolio!');
      return Redirect::to('home');

    }

    public function destroy($id) {
      $this->model->destroy($id);
      Session::flash('message', 'Successfully deleted the coin from Portfolio!');
      return Redirect::to('home');
    }

    public function store(CoinRequest $request) {
      $this->model->create($request);
      Session::flash('message', 'Successfully Added New Coin!');
      return Redirect::to('home');
    }

    public function coinDetails($id) {
      return View::make('portfolio.coinDetails')->with([
        'coins' => $this->model->getCoinDetailWithId($id),
        'coinDetails' => $this->model->getCoinDetails($id),
        'coinTotalValue' => $this->model->getCoinTotalValue($id)
      ]);
    }
}
