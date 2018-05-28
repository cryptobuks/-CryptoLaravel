@extends('layouts.app')


@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <a class="btn btn-small btn-primary" href="{{ URL::to('home') }}">Return To Home</a>
      <hr>
      <div class="panel panel-primary">
        <div class="panel-heading">Edit {{ $portfolio->coin_name }} Details</div>
        <div class="panel-body">
          <div class="col-md-12">
            {{ Html::ul($errors->all()) }}
            {{ Form::model($portfolio, array('route' => array('home.update', $portfolio->id), 'method' => 'PUT')) }}
            {{ Form::hidden('coin', $portfolio->coin_name, array('id' => 'coin')) }}
            <div class="form-group">
              {{ Form::label('Buy Price', 'Buy Price') }}
              {{ Form::text('buy_price', Request::old('buy_price'), array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
              {{ Form::label('Amount', 'Amount') }}
              {{ Form::text('amount', Request::old('amount'), array('class' => 'form-control')) }}
            </div>
            <div class="form-group">
              {{ Form::label('Date Purchased', 'Date Purchased') }}
              {{ Form::text('date_purchased', Request::old('date_purchased'), array('id' => 'datepicker', 'class' => 'date form-control'))}}
            </div>
              {{ Form::submit('Edit the Coin Details!', array('class' => 'btn btn-primary')) }}
              {{ Form::close() }}
          </div>
        </div>
      </div>
    </div>
</div>
</div>
<script>
$('#datepicker').datepicker({
  autoclose: true,
  format: 'yy-m-d',
  endDate: new Date()
});
</script>
@endsection
