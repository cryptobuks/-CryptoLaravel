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
      $coinTotalAmount = $this->model->getCoinTotalAmount();
      $initialPortfolioValue = $this->model->calculateInitialPortfolioValue();
      $totalMarketValue = $this->model->calculateTotalMarketValue();
      $returnOfInvestment = round($totalMarketValue - $initialPortfolioValue, 2);
      $returnOfInvestmentPercentage = round($totalMarketValue / $initialPortfolioValue * 100, 2);

      return View::make('home')->with([
        'coins' => $coinTotalAmount,
        'portfolio' => $this->model->getAll(),
        'initialPortfolioValue' => $initialPortfolioValue,
        'totalMarketValue' => $totalMarketValue,
        'returnOfInvestment' => $returnOfInvestment,
        'returnOfInvestmentPercentage' => $returnOfInvestmentPercentage,
        'chart' => $this->model->createChart()
      ]);
    }

    public function store(CoinRequest $request) {
      $this->model->create($request);
      Session::flash('message', 'Successfully Added New Coin!');
      return Redirect::to('home');
    }

    public function coinDetails($id) {
      return View::make('coinDetails')->with([
        'coins' => $this->model->getCoinDetailWithId($id),
        'coinDetails' => $this->model->getCoinDetails($id),
        'coinTotalValue' => $this->model->getCoinTotalValue($id)
      ]);
    }
}
