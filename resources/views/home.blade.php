@extends('layouts.app')


@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
             <div class="border row row-eq-height">
                <div class="border col-lg-3">
                  <h3>Total Market Value</h3>
                  <h4>${{ $totalMarketValue }}</h4>
                </div>
                <div class="border col-lg-3">
                  <h3>Initial Portfolio Value</h3>
                  <h4>${{ $initialPortfolioValue }}</h4>
                </div>
                <div class="border col-lg-3">
                  <h3>ROI</h3>
                  <h4>${{ $returnOfInvestment }} ({{ $returnOfInvestmentPercentage }} %) </h4>
                </div>
                <div class="border col-lg-3">
                  <h3>-</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
      <div class="col-4 mx-auto">
          <div class="card card-body mb-2">
            {{ Form::open(array('action' => 'PortfolioController@store')) }}
            {{Form::token()}}
              @if (Session::has('message'))
                <div class="alert alert-info">{{Session::get('message') }}</div>
              @endif
              <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Add New Coin</label>
              <div class="form-group row">
                <label for="inputName" class="col-sm-3 col-form-label">Name:</label>
                <div class="col-sm-9">
                  <input type="text" name="coin" class="form-control" placeholder="Search coin..">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputAmount" class="col-sm-3 col-form-label">Amount:</label>
                <div class="col-sm-3">
                  <input type="number" name="amount" class="form-control" required="required">
                </div>
                <label for="inputPrice" class="col-sm-3 col-form-label">Price:</label>
                <div class="col-sm-3">
                  <input type="number" name="price" class="form-control" required="required">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputDatePurchased" class="col-sm-3 col-form-label">Date Purchased:</label>
                <div class="col-sm-9">
                  <input type="text" name="date" class="date form-control" id="datepicker" size="4">
                </div>
              </div>
            {{ Form::submit('Create!', array('class' => 'btn btn-primary')) }}
            {{ Form::close() }}
          </div>
      </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
             <div class="border row row-eq-height">
                <div class="border col-lg-6">
                  <table class="table table-striped table-bordered">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Symbol</th>
                        <th>Total Amount</th>
                        <th>Value</th>
                        <th>24h Change</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($coins as $key => $value)
                    <tr>
                      <td><a href="{{ URL::to('coinDetails/' . $value->CryptoCurrency->id)}}">{{ $value->CryptoCurrency->name }}</a></td>
                      <td>{{ $value->CryptoCurrency->symbol }}</td>
                      <td>{{ $value->totalAmount }}</td>
                      <td>{{ $value->total_coin_value }}
                    </tr>
                    @endforeach
                    </tbody>
                  </table>

                </div>
                <div class="border col-lg-6">.col-lg-3<br>aaa<br>aa</div>
            </div>
        </div>
    </div>
</div>

<script>
$('#datepicker').datepicker({
            autoclose: true,
            format: 'dd-mm-yyyy',
            endDate: new Date()
         });
$('div.alert').delay(3000).slideUp(300);
</script>

@endsection
