<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\ProfitLossChart;
use App\Http\Controllers\Controller;
use App\Portfolio;
use DB;
class ChartsController extends Controller
{
    public function chart() {
      $chart = new ProfitLossChart;
      //dd([100, 65, 84, 45, 90]);
      $data = Portfolio::pluck('amount')->toArray();
      $labels = Portfolio::selectRaw('(@sum := @sum + (buy_price * amount)) as running_amount')
      ->crossJoin(DB::raw('(select @sum := 0) params'))
      ->orderBy('date_purchased', 'asc')
      ->pluck('running_amount')
      ->toArray();
      //dd($labels);
      //$request->user()->get(['id'])->groupBy('id')->keys()->all();
      //dd($data);
      $chart->labels($labels);
      $chart->dataset('Sample', 'line', $data)
      ->options([
        'borderColor' => '#ff0000'
      ]);
      return view('chart', ['chart' => $chart]);

    }
}
