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
use App\CryptoCurrency;
use App\Http\Requests\CoinRequest;
use Auth;
use Illuminate\Support\Facades\Input;
use App\Charts\PortfolioValueChart;
use DateTime;
use DatePeriod;
use DateInterval;

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
      $chart = $this->chart();

      return View::make('home')->with([
        'coins' => $coins,
        'portfolio' => $portfolio,
        'initialPortfolioValue' => $initialPortfolioValue,
        'totalMarketValue' => $totalMarketValue,
        'returnOfInvestment' => $returnOfInvestment,
        'returnOfInvestmentPercentage' => $returnOfInvestmentPercentage,
        'chart' => $chart
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

    public function chart() {
      $chart = new PortfolioValueChart;
      # Gets current total coin value .
      $data = DB::table('portfolio AS p')
        ->selectRaw('p.date_purchased,sum(p.amount * cp.price) AS dayValue')
        ->join('coin_price AS cp', function($join){
            $join->on('p.date_purchased' , '=', 'cp.date')
                 ->on('p.coin_id' , '=', 'cp.coin_id');
        })
        ->groupBy('p.date_purchased')
        ->orderBy('p.date_purchased', 'asc')
        ->get()
        ->toArray();

      //dd($data);

      $earliest = new DateTime(Portfolio::oldest('date_purchased')->first()->date_purchased);
      $latest = new DateTime(Portfolio::latest('date_purchased')->first()->date_purchased);
      $end = new DateTime("now");
      $di = new DateInterval('P1D');
      $period = new DatePeriod($earliest, $di, $end);
      // Calculates cumulative portfolio value. Adds previous day onto current day.
      $cumulative = array();
      $cumulative[0] = (object)array('date_purchased' => $data[0]->date_purchased, 'total' => (double)$data[0]->dayValue);
      for($i = 1; $i < count($data); $i++) {
        $cumulative[] = (object)array('date_purchased' => $data[$i]->date_purchased, 'total' => $data[$i]->dayValue + $cumulative[$i - 1]->total);
      }
      // Fills empty dates with previous day's portfolio value.
      $graphData = array();
      $index = 0;
      for($i = $earliest; $i <= $latest; $i->modify('+1 day')) {
        if (isset($cumulative[$index]) && $i->format('Y-m-d') == $cumulative[$index]->date_purchased) {
          $graphData[] = $cumulative[$index]->total;
          $index++;
        } else {
          $graphData[] = $cumulative[$index - 1]->total;
        }
        //echo '<pre>'; print_r($labels); echo '</pre>';
      }
      // Ensures data size is same as label size.
      for($i = $latest; $i <= $end; $i->modify('+1 day')) {
        $graphData[] = $graphData[count($graphData) - 1];
      }
      //dd($graphData);
      // Generates the labels using earliest date value to now.
      $labels = array();
      $labelEarliest = new DateTime(Portfolio::oldest('date_purchased')->first()->date_purchased);
      for($i = $labelEarliest; $i <= $end; $i->modify('+1 day')) {
        $labels[] = $i->format('d-M');
      }

      $chart->labels($labels);
      $chart->dataset('Sample', 'line', $graphData)
        ->options([
          'borderColor' => '#c8e2f2',
          'backgroundColor' => '#7cb9e8'
        ]);
      return $chart;

    }

    public function store(CoinRequest $request) {
      //dd($request->all());
      $validated = $request->validated();
      $portfolio = new Portfolio;
      $portfolio->coin_id = CryptoCurrency::select('id')->where('name', Input::get('coin'))->first()->id;
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

      $coinTotalValue = DB::table('portfolio AS p')
        ->selectRaw('sum(p.amount) * c.price_usd AS value')
        ->join('cryptocurrency AS c', 'c.id', '=', 'p.coin_id')
        ->where([
          ['p.user_id', '=', Auth::user()->id],
          ['p.coin_id', '=', $id],
        ])->first();
      $coinDetails = CryptoCurrency::where('id', $id)->first();
      $coins = Portfolio::where([
          ['user_id', '=', Auth::user()->id],
          ['coin_id', '=', $id]
        ])->get();

      return View::make('coinDetails')->with([
        'coins' => $coins,
        'coinDetails' => $coinDetails,
        'coinTotalValue' => $coinTotalValue
      ]);
    }
}
