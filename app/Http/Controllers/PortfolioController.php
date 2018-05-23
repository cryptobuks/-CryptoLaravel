<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Validator;
use Session;
use Redirect;
use App\Portfolio;
use App\Http\Requests\CoinRequest;
use Auth;
use Illuminate\Support\Facades\Input;
class PortfolioController extends Controller
{
    public function index() {
      $portfolio = Portfolio::all();
      $coins = Portfolio::groupBy('coin_id')
      ->selectRaw('sum(amount) as totalAmount, coin_id')
      ->orderBy('amount','asc')->get();
      #dd(Portfolio::all()->first()->CryptoCurrency);
      //return view('home', compact('coins'));
      $initialPortfolioValue = $this->calculateInitialPortfolioValue()->value;
      $totalMarketValue = $this->calculateMarketValue()->value;
      $returnOfInvestment = round($totalMarketValue - $initialPortfolioValue, 2);
      $returnOfInvestmentPercentage = round($totalMarketValue / $initialPortfolioValue * 100, 2);
      //dd($roi);
      //dd($totalMarketValue);
      //dd($initialPortfolioValue);
      return View::make('home')->with([
        'coins' => $coins,
        'portfolio' => $portfolio,
        'initialPortfolioValue' => $initialPortfolioValue,
        'totalMarketValue' => $totalMarketValue,
        'returnOfInvestment' => $returnOfInvestment,
        'returnOfInvestmentPercentage' => $returnOfInvestmentPercentage
      ]);
    }

    public function calculateInitialPortfolioValue() {
      return Portfolio::where('user_id', Auth::user()->id)
        ->selectRaw('sum(buy_price * amount) as value')
        ->first();
    }

    public function calculateMarketValue() {
      return Portfolio::where('user_id', Auth::user()->id)
        ->join('cryptocurrency', 'coin_id', '=', 'cryptocurrency.id')
        ->selectRaw('sum(cryptocurrency.price_usd * amount) as value')
        ->first();
    }

    public function store(CoinRequest $request) {
      $validated = $request->validated();
      $portfolio = new Portfolio;
      $portfolio->coin_id = 1;
      $portfolio->user_id = Auth::user()->id;
      $portfolio->buy_price = Input::get('price');
      $portfolio->amount = Input::get('amount');
      $portfolio->date_purchased = Input::get('date');
      $portfolio->created_at = Carbon::now();
      $portfolio->save();
      Session::flash('message', 'Successfully Added New Coin!');
      return Redirect::to('home');
    }

    public function coinDetails($id) {
      $coins = Portfolio::where('coin_id', $id)->get();
      return View::make('coinDetails')->with('coins', $coins);
    }
}
