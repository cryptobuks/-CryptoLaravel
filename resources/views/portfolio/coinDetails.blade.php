@extends('layouts.app')


@section('content')

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <a class="btn btn-small btn-primary" href="{{ URL::to('home') }}">Return To Home</a>
      <h1>{{ $coinDetails->name }} | Portfolio Value (USD): ${{$coinTotalValue->totalValue}}</h1>
      <hr>
      <div class="panel panel-primary">
        <div class="panel-heading">Details - Last Updated {{ $coinDetails->last_updated_formatted }}</div>
        <div class="panel-body">
          <div class="col-md-12">
               <div class="border row row-eq-height">
                  <div class="border col-lg-3">
                    <h4>Rank: {{ $coinDetails->rank }}</h4>
                  </div>
                  <div class="border col-lg-3">
                    <h4>Name: {{ $coinDetails->name }}</h4>
                  </div>
                  <div class="border col-lg-3">
                    <h4>Symbol: {{ $coinDetails->symbol }}</h4>
                  </div>
                  <div class="border col-lg-3">
                    <h4>Price(USD): {{ $coinDetails->price_usd }}</h4>
                  </div>
              </div>
              <div class="border row row-eq-height">
                 <div class="border col-lg-3">
                   <h4>24 Hr Volume: {{ $coinDetails->{'24h_volume_usd'} }}</h4>
                 </div>
                 <div class="border col-lg-3">
                   <h4>Market Cap: {{ $coinDetails->market_cap_usd }}</h4>
                 </div>
                 <div class="border col-lg-3">
                   <h4>Available Supply: {{ $coinDetails->available_supply }}</h4>
                 </div>
                 <div class="border col-lg-3">
                   <h4>Total Supply: {{ $coinDetails->total_supply }}</h4>
                 </div>
             </div>
             <div class="border row row-eq-height">
                <div class="border col-lg-4">
                  <h4>1 Hour Change: {{ $coinDetails->percent_change_1h }} %</h4>
                </div>
                <div class="border col-lg-4">
                  <h4>24 Hour Change: {{ $coinDetails->percent_change_7d }} %</h4>
                </div>
                <div class="border col-lg-4">
                  <h4>7 Day Change: {{ $coinDetails->percent_change_24h }} %</h4>
                </div>
            </div>
          </div>

        </div>
      </div>

      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Buy Price</th>
            <th>Amount</th>
            <th>Initial Value</th>
            <th>Current Value</th>
            <th>Profit</th>
            <th>Date Purchased</th>
            <th>Date Added</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        @foreach($coinData as $value)
          <tr>
            <td>{{ $value->buy_price }}</td>
            <td>{{ $value->amount }}</td>
            <td>{{ $value->initialValue }}</td>
            <td>{{ $value->currentValue }}</td>
            <td>{{ $value->profit }}</td>
            <td>{{ $value->date_purchased }}</td>
            <td>{{ $value->created_at }}</td>
            <td>
              <a class="btn btn-small btn-info" href="{{ URL::to('edit/' . $value->id )}}">Edit Details</a>
              {{ Form::open(array('url' => 'home/' . $value->id, 'class' => 'pull-right')) }}
              {{ Form::hidden('_method', 'DELETE') }}
              {{ Form::submit('Delete', array('class' => 'btn btn-warning'))}}
              {{ Form::close() }}
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
