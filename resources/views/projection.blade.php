@extends('layouts.dashboardHeader')
@if($status =="month")
<script>
    var Q1 = JSON.parse({{$Q1}});
    var Q2 = JSON.parse({{$Q2}});
    var Q3 = JSON.parse({{$Q3}});
    var Q4 = JSON.parse({{$Q4}});
    var q1dana = JSON.parse({{$q1dana}});
    var q2dana = JSON.parse({{$q2dana}});
    var q3dana = JSON.parse({{$q3dana}});
    var q4dana = JSON.parse({{$q4dana}});

</script>
@elseif($status =="year")
    <script>
        var duration = JSON.parse({{$duration}});
        var sales = <?php echo json_encode($sales)?>;
        var year = JSON.parse({{$year}});
        var target = JSON.parse({{$target}});

    </script>
@endif
@section('content')

    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Sales in a Year
                <div class="pull-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
                            Finance Projection
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li><a href="{{route('month')}}" name="month" id="month">Quarter</a>
                            </li>
                            <li><a href="{{route('year')}}" name="year" id="year">Per Year</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                    @if($status=="month")
                    <div class="panel-body">
                        <div id="Finance-Projection-Chart-Month"></div>
                    </div>
                    @if ($error =="targetmore")
                        <div class="alert alert-danger">
                            You have set a new target
                        </div>
                    @endif
                    @elseif($status=="year")
                    <div class="panel-body">
                        <div id="Finance-Projection-Chart-Year"></div>
                    </div>
                    @else
                        <div class="panel-body">
                            To use Finance Projection, please choose one of the menu available in the top right.
                            This finance projection come in 2 type. By Quarters and by Years
                        </div>
                @endif
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    @if($status =="normal")

    @else
    <div class="col-lg-6">
        <div class="panel panel-default">

            <div class="panel-heading">
                Main Board
            </div>
            <div class="panel-body">
                <div class="row">
                    @if($status =="month")
                        <div class="col-lg-8">
                            <form action ="/projection/month" role="form">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label>Year of Projection</label>
                                    <input class="form-control" placeholder="YYYY" name="projectionyear">
                                    <label>Q1 Target</label>
                                    <input class="form-control" placeholder="Target" name="q1target">
                                    <label>Q2 Target</label>
                                    <input class="form-control" placeholder="Target" name="q2target">
                                    <label>Q3 Target</label>
                                    <input class="form-control" placeholder="Target" name="q3target">
                                    <label>Q4 Target</label>
                                    <input class="form-control" placeholder="Target" name="q4target">
                                </div>
                                <button type="submit" class="btn btn-default">Submit Button</button>
                                <button type="reset" class="btn btn-default">Reset Button</button>
                            </form>
                        </div>
                    @elseif($status =="year")
                    <div class="col-lg-8">
                        <form action ="/projection/year" role="form">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>Starting Year</label>
                                <input class="form-control" placeholder="YYYY" name="projectionyear">
                                <label>Duration</label>
                                <input class="form-control" placeholder="Duration" name="duration">
                                <label>Target</label>
                                <input class="form-control" placeholder="Target" name="target">
                            </div>
                            <button type="submit" class="btn btn-default">Submit Button</button>
                            <button type="reset" class="btn btn-default">Reset Button</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
                @endif
        </div>
    </div>
@endsection