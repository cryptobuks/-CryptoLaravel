@extends('layouts.app')


@section('content')

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
             <div class="border row row-eq-height">
                <div class="border col-lg-4">
                  <h3>Total Market Value</h3>
                  <h4>${{ $totalMarketValue }}</h4>
                </div>
                <div class="border col-lg-4">
                  <h3>Initial Portfolio Value</h3>
                  <h4>${{ $initialPortfolioValue }}</h4>
                </div>
                <div class="border col-lg-4">
                  <h3>ROI</h3>
                  <h4>${{ $returnOfInvestment->value }} ({{ $returnOfInvestment->percentage }} %) </h4>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <h2 class="display-4 text-center">Portfolio Value</h2>
        <div>{!! $chart->container() !!}</div>
        {!! $chart->script() !!}
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
                        <th>Current Value</th>
                      </tr>
                    </thead>
                    <tbody>
                    @foreach($coins as $key => $value)
                    <tr>
                      <td><a href="{{ URL::to('coinDetails/' . $value->CryptoCurrency->id)}}">{{ $value->CryptoCurrency->name }}</a></td>
                      <td>{{ $value->CryptoCurrency->symbol }}</td>
                      <td>{{ $value->amount }}</td>
                      <td>{{ $value->CryptoCurrency->price_usd * $value->amount}}</td>
                    </tr>
                    @endforeach
                    </tbody>
                  </table>

                </div>
                <div class="border col-lg-6">
                  <div class="row">
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
                            <input type="text" name="coin" id="searchCoin" class="form-control" placeholder="Search coin.." autocomplete="off">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputAmount" class="col-sm-3 col-form-label">Amount:</label>
                          <div class="col-sm-3">
                            <input type="number" name="amount" class="form-control" required="required">
                          </div>
                          <label for="inputPrice" class="col-sm-3 col-form-label">Price:</label>
                          <div class="col-sm-3">
                            <input type="number" name="buy_price" class="form-control" required="required" step=".01">
                          </div>
                        </div>
                        <div class="form-group row">
                          <label for="inputDatePurchased" class="col-sm-3 col-form-label">Date Purchased:</label>
                          <div class="col-sm-9">
                            <input type="text" name="date_purchased" class="date form-control" id="datepicker" size="4">
                          </div>
                        </div>
                      {{ Html::ul($errors->all()) }}
                      {{ Form::submit('Create!', array('class' => 'btn btn-primary')) }}
                      {{ Form::close() }}
                    </div>
                  </div>
                </div>
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


var engine = new Bloodhound({
  remote: {
    url: '/find?q=%QUERY%',
    wildcard: '%QUERY%'
  },
    datumTokenizer: Bloodhound.tokenizers.whitespace('q'),
    queryTokenizer: Bloodhound.tokenizers.whitespace
  });

$('#searchCoin').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
}, {
  name: 'cryptocurrency',
  source: engine,
  display: function(data) {
    console.log(data);
      return data.name  //Input value to be set when you select a suggestion.
},
  templates: {
    empty: [
      '<div class="list-group search-results-dropdown"><div class="list-group-item">Nothing found.</div></div>'
    ],
    header: [
      '<div class="list-group search-results-dropdown">'
    ],
    suggestion: function(data) {
      return '<div style="font-weight:normal; margin-top:-10px ! important;" class="list-group-item">' + data.name + '</div></div>'
    }
  }
  });


</script>

@endsection
