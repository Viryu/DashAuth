@extends('layouts.dashboardHeader')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                {{--Headings--}}
                <div class="panel-heading">
                    Devices
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                           <th>Serial Number</th>
                           <th>Merchant Name</th>
                            <th>TID</th>
                        </thead>
                        <tbody>
                        @foreach($device as $device)
                            <tr>
                                <td>
                                    {{$device->serial_number}}
                                </td>
                                <td>
                                    {{$device->merchant_name}}
                                </td>
                                <td>
                                    {{$device->TID}}
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