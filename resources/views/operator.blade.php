@extends('layouts.dashboardHeader')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                {{--Headings--}}
                <div class="panel-heading">
                    Operators
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <th>Operator Id</th>
                        <th>Operator Name</th>
                        <th>Merchant Code</th>
                        <th>Merchant Name</th>
                        <th>Last Login</th>
                        </thead>
                        <tbody>
                        @foreach($operators as $operators)
                        <tr>
                            <td>
                                {{$operators->operator_code}}
                            </td>
                            <td>
                                {{$operators->operator_name}}
                            </td>
                            <td>
                                {{$operators->merchant_code}}
                            </td>
                            <td>
                                {{$operators->merchant_name}}
                            </td>
                            <td>
                                {{$operators->last_login_date}}
                            </td>
                        </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
@endsection