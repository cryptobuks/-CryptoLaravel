@extends('layouts.app')


@section('content')

<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <a class="btn btn-small btn-primary" href="{{ URL::to('home') }}">Return To Home</a>
      <h1>{{ $coins->first()->coin_name }} | Current Price (USD): ${{ $coins->first()->current_price }}</h1>
      <hr>
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
          </tr>
        </thead>
        <tbody>
        @foreach($coins as $key => $value)
        <tr>
          <td>{{ $value->buy_price }}</td>
          <td>{{ $value->amount }}</td>
          <td>{{ $value->initial_coin_value }}</td>
          <td>{{ $value->current_coin_value }}</td>
          <td>{{ $value->profit }}</td>
          <td>{{ $value->date_purchased }}</td>
          <td>{{ $value->created_at }}</td>
        </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
