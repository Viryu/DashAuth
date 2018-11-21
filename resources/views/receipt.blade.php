<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="stylesheet" href="{{URL::asset('receiptbootstrap/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{URL::asset('receiptbootstrap/css/styles.css')}}">
</head>

<body>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row header">
                <div class="col-md-6"><img class="img-responsive" src="{{URL::asset('receiptbootstrap/img/CIMB_Niaga_logo.gif')}}" width="70%"></div>
                <div class="col-lg-offset-0 col-md-6">
                    <h2 class="text-right">Payment Information</h2></div>
            </div>
        </div>
        <div class="panel-body">
            <div class="row">
            @foreach($data as $data)
                <div class="col-md-12">
                    <h3>Ref Transaction : {{$data->name}}</h3></div>
                <div class="col-md-12">
                    <h3>Card Number: {{$data->card_number}}</h3></div>
                <div class="col-md-12">
                    <h3>Type : {{$data->card_type}}</h3></div>
                <div class="col-md-12">
                    <h3>Amount :        <?php
                                        $amount = number_format($data->amount,0,',','.');
                                        ?>
                                        {{$amount}}</h3></div>
                <div class="col-md-12">
                    <h3>Status : {{$data->response_description}}</h3></div>
            @endforeach
            </div>
        </div>
    </div>
    <script src="{{URL::asset('receiptbootstrap/js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('receiptbootstrap/bootstrap/js/bootstrap.min.js')}}"></script>
</body>

</html>