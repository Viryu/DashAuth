<!DOCTYPE html>
<html lang="en">

@extends('layouts.dashboardHeader')

<script>
    var salesonly = JSON.parse({{$transactionsalesonly}});
    var failonly = JSON.parse({{$salesvoid}});
    var totalmoney = JSON.parse({{$moneytotal}});
    var settarget = JSON.parse({{$usertarget}});
    var transactionday1 = JSON.parse({{$transactionday1}});
    var transactionday2 = JSON.parse({{$transactionday2}});
    var transactionday3 = JSON.parse({{$transactionday3}});
    var transactionday4 = JSON.parse({{$transactionday4}});
    var transactionday5 = JSON.parse({{$transactionday5}});
    var transactionday6 = JSON.parse({{$transactionday6}});
    var transactionday7 = JSON.parse({{$transactionday7}});
    var transactioncountday1 = JSON.parse({{$transactioncountday1}});
    var transactioncountday2 = JSON.parse({{$transactioncountday2}});
    var transactioncountday3 = JSON.parse({{$transactioncountday3}});
    var transactioncountday4 = JSON.parse({{$transactioncountday4}});
    var transactioncountday5 = JSON.parse({{$transactioncountday5}});
    var transactioncountday6 = JSON.parse({{$transactioncountday6}});
    var transactioncountday7 = JSON.parse({{$transactioncountday7}});
</script>

<body>
@section('content')
    <div class="row">
        <h1 class="page-header">Dashboard</h1>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-comments fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge">{{$transactiontotal}}</div>
                            <div>All Transactions!</div>
                        </div>
                    </div>
                </div>
                <a href="/alltransaction">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>

            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="sales">{{$transactionsalesonly}}</div>
                            <div>Approved Transactions!</div>
                        </div>
                    </div>
                </div>
                <a href="/salesonly">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-tasks fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="sales">{{$salesvoid}}</div>
                            <div>Void Sales</div>
                        </div>
                    </div>
                </div>
                <a href="/salesonly">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Your Target this Year!
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    @if(Auth::user()->target == 0 || Auth::user()->target =="NULL")
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-pie-chart1"></div>
                        </div>
                        <div>
                            You didnt set any target this year right now
                        </div>
                    @else
                    <div>
                        <h3 style="text-align: center">Target in a Year Rp. {{$targetnumber}}</h3>
                    </div>
                    <div class="flot-chart">
                        <div class="flot-chart-content" id="flot-pie-chart1"></div>
                    </div>
                    @endif
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-desktop fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="fail">{{$devices}}</div>
                            <div>Issued Devices</div>
                        </div>
                    </div>
                </div>
                <a href="/devices">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-2">
                            <i class="fa fa-balance-scale fa-5x"></i>
                        </div>
                        <div class="col-xs-10 text-right">
                            <div class="huge" id="sales"><p style="font-size:30px" >Rp{{$salestotal}}</p></div>
                            <div>Total Transaction</div>
                        </div>
                    </div>
                </div>
                <a href="/salesonly">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-archive fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge" id="sales">{{$merchant}}</div>
                            <div>Enrolled Merchant</div>
                        </div>
                    </div>
                </div>
                <a href="/salesonly">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        {{--Second Row--}}
        <div class="col-lg-6 col-md-4">

        </div>
        <div class="col-lg-6 col-md-6">
            <!-- /.panel -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Sales/Fail sales Ratio
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="flot-chart">
                            <div class="flot-chart-content" id="flot-pie-chart"></div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.panel -->

            <!-- /.panel-body -->
            <!-- /.panel -->
         </div>
    <!-- /.row -->
    <div class="row">
        <!-- /.panel -->
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Sales in a week
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="panel-body">
                        <div id="morris-bar-chart"></div>
                    </div>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.panel -->
        </div>

        <!-- /.col-lg-8 -->
        {{--<div class="col-lg-4">--}}
            {{--<div class="panel panel-default">--}}
                {{--<!-- /.panel-heading -->--}}
                {{--<!-- /.panel-body -->--}}
            {{--</div>--}}
            <!-- /.panel -->
            <!-- /.panel -->

            <!-- /.panel-heading -->

            <!-- /.panel-body -->
            <!-- /.panel-footer -->
        {{--</div>--}}
        <!-- /.panel .chat-panel -->
    </div>
    <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
    <!-- /#wrapper -->

</body>
@endsection
</html>
