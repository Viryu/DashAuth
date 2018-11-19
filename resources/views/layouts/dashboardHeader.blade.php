<!DOCTYPE html>
<html lang="en">

<head>
<?php
    $time = \Carbon\Carbon::now();
    $datetoday = \Carbon\Carbon::now()->toDateString();

    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Merchant Dashboard</title>
    <link href="{{URL::asset('morrisjs/morris.css')}}" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="{{URL::asset('bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{URL::asset('metisMenu/metisMenu.min.css')}}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{URL::asset('dist/css/sb-admin-2.css')}}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{URL::asset('font-awesome/css/font-awesome.min.css')}}" rel="stylesheet" type="text/css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Bootstrap Core JavaScript -->
    <!-- jQuery -->
    <script src="{{URL::asset('jquery/jquery.min.js')}}"></script>
    <script src="{{URL::asset('bootstrap/js/bootstrap.min.js')}}"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="{{URL::asset('metisMenu/metisMenu.min.js')}}"></script>

    <!-- Custom Theme JavaScript -->
    <script src="{{URL::asset('dist/js/sb-admin-2.js')}}"></script>

    <!-- Morris Charts JavaScript -->
    <script src="{{URL::asset('raphael/raphael.min.js')}}"></script>
    <script src="{{URL::asset('morrisjs/morris.min.js')}}"></script>

    <script src="{{URL::asset('data/morris-data.js')}}"></script>
    <script src="{{URL::asset('datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::asset('datatables-plugins/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::asset('datatables-responsive/dataTables.responsive.js')}}"></script>
    <!-- DataTables CSS -->
    <link href="{{URL::asset('datatables-plugins/dataTables.bootstrap.css')}}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{URL::asset('datatables-responsive/dataTables.responsive.css')}}" rel="stylesheet">

    {{--Pie Data--}}
    <script src="{{URL::asset('flot/excanvas.min.js')}}"></script>
    <script src="{{URL::asset('flot/jquery.flot.js')}}"></script>
    <script src="{{URL::asset('flot/jquery.flot.pie.js')}}"></script>
    <script src="{{URL::asset('flot/jquery.flot.resize.js')}}"></script>
    <script src="{{URL::asset('flot/jquery.flot.time.js')}}"></script>
    <script src="{{URL::asset('flot-tooltip/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{URL::asset('data/flot-data.js')}}"></script>

    <script>
        var timer;
        function my_Clock()
        {
            this.cur_date = new Date();
            this.hours = this.cur_date.getHours();
            this.minutes = this.cur_date.getMinutes();
            this.seconds = this.cur_date.getSeconds();
        }
        my_Clock.prototype.run = function ()
        {
            setInterval(this.update.bind(this), 1000);
        };
        my_Clock.prototype.update = function ()
        {
            this.updateTime(1);
//            console.log(this.hours + ":" + this.minutes + ":" + this.seconds);
            timer = document.getElementById("timer").innerHTML = this.hours + ":" + this.minutes + ":" + this.seconds;
        };
        my_Clock.prototype.updateTime = function (secs)
        {
            this.seconds+= secs;
            if (this.seconds >= 60)
            {
                this.minutes++;
                this.seconds= 0;
            }
            if (this.minutes >= 60)
            {
                this.hours++;
                this.minutes=0;
            }
            if (this.hours >= 24)
            {
                this.hours = 0;
            }
        };
        var clock = new my_Clock();
        clock.run();
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php
                if(Auth::check()== false){
                    return redirect('/');
                }
            ?>
            @if(Auth::user()->role=="admin")
                <a class="navbar-brand" href="/">Dashboard Admin - Visionet</a>
                <a class="navbar-brand">Current Time : {{$time->toDateString()}}</a>
                <a class="navbar-brand" id="timer"></a>
            @endif
            @if(Auth::user()->role=="merchant")
                <a class="navbar-brand" href="/">Dashboard Merchant - Visionet</a>
                <a class="navbar-brand">Current Time : {{$time->toDateString()}} </a>
                <a class="navbar-brand" id="timer"></a>
            @endif
        </div>
        <!-- /.navbar-header -->
        <ul class="nav navbar-top-links navbar-right">
            <!-- /.dropdown -->
            <li class="dropdown">
                <!-- /.dropdown-alerts -->
            </li>
            <li>
                Welcome Back , {{Auth::user()->name}}
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="/dashboard/profile"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li class="divider"></li>
                    <li class="nav-item dropdown">
                        <div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li>
                        <a href="/"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    @if(Auth()->user()->role == 'admin')
                        <li>
                            <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Administration<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href={{ route('register') }}><i class="fa fa-edit fa-fw"></i>Register User</a>
                                </li>
                                {{--<li>--}}
                                    {{--<a href={{ route('registerMidTid') }}><i class="fa fa-edit fa-fw"></i>Register MID TID</a>--}}
                                {{--</li>--}}
                                <li>
                                    <a href="/administrator"><i class="fa fa-archive"></i> Administrator</a>
                                </li>
                                <li>
                                    <a href="/insertbin"><i class="fa fa-briefcase">Insert New BIN</i></a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    <li>
                        <a href="#"><i class="fa fa-table fa-fw"></i> Transaction Detail<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <a href="/alltransaction">All Record</a>
                            </li>
                            <li>
                                <a href="/salesonly">Sale Transaction Record</a>
                            </li>
                            <li>
                                <a href="/failtransaction">Void Transaction Record</a>
                            </li>
                            <li>
                                <a href="/projection">Finance Projection</a>
                            </li>
                        </ul>
                        <!-- /.nav-second-level -->
                    </li>
                    <li>
                        <a href="/devices"><i class="fa fa-desktop fa-fw"></i> Device</a>
                    </li>
                    <li>
                        <a href="{{route('profile')}}"><i class="fa fa-briefcase fa-fw"></i> Profile</a>
                    </li>
                    <li>
                        <a href="/operators"><i class="fa fa-bell"></i> Operator</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->




@yield('script')


</body>

</html>
