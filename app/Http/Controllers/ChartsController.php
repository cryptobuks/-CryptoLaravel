<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\PortfolioValueChart;
use App\Http\Controllers\Controller;
use App\Portfolio;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;

class ChartsController extends Controller
{
    public function chart() {
      $chart = new PortfolioValueChart;
      //dd([100, 65, 84, 45, 90]);
      //$data = Portfolio::pluck('amount')->toArray();
      // $data = Portfolio::selectRaw('(@sum := @sum + (buy_price * amount)) as running_amount')
      // ->crossJoin(DB::raw('(select @sum := 0) params'))
      // ->orderBy('date_purchased', 'asc')
      // ->pluck('running_amount')
      // ->toArray();

      // $data = DB::table('portfolio AS p')
      // ->selectRaw('p.date_purchased, (@sum := @sum + (cp.price * p.amount)) as running_amount')
      // ->crossJoin(DB::raw('(select @sum := 0) params'))
      // ->join('coin_price as cp', function($join){
      //     $join->on('p.date_purchased' , '=', 'cp.date')
      //          ->on('p.coin_id' , '=', 'cp.coin_id');
      // })
      // ->whereRaw('p.date_purchased = cp.date')
      // ->orderBy('date_purchased', 'asc')
      // ->get()
      // ->toArray();

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

      $cumulative = array();
      $cumulative[0] = (object)array('date_purchased' => $data[0]->date_purchased, 'total' => (double)$data[0]->dayValue);
      for($i = 1; $i < count($data); $i++) {
          $cumulative[] = (object)array('date_purchased' => $data[$i]->date_purchased, 'total' => $data[$i]->dayValue + $cumulative[$i - 1]->total);
      }
      //dd($cumulative);

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
      for($i = $latest; $i <= $end; $i->modify('+1 day')) {
        $graphData[] = $graphData[count($graphData) - 1];
      }

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
      return view('chart', ['chart' => $chart]);

    }

}
