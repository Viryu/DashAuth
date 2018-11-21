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
                <div class="col-md-12">
                    <h3>Ref Transaction : </h3></div>
                <div class="col-md-12">
                    <h3>Card Number:</h3></div>
                <div class="col-md-12">
                    <h3>Type : </h3></div>
                <div class="col-md-12">
                    <h3>Amount : </h3></div>
                <div class="col-md-12">
                    <h3>Status : </h3></div>
            </div>
        </div>
    </div>
    <script src="{{URL::asset('receiptbootstrap/js/jquery.min.js')}}"></script>
    <script src="{{URL::asset('receiptbootstrap/bootstrap/js/bootstrap.min.js')}}"></script>
</body>

</html>