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
      // groupBy('coin_id')
      // ->selectRaw('sum(amount) as sum, coin_id')
      // ->pluck('sum','id');
      //dd($coins);
      return view('home', compact('coins'));
      //return View::make('restaurants.index')->with('restaurants', $restaurants);
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
}
