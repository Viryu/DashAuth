@extends('layouts.dashboardHeader')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    All Transactions
                    <a href="/exportall">
                        <button>Export to Excel (XLS)</button>
                    </a>
                    <a href="/exportallcsv">
                        <button>Export to Excel (CSV)</button>
                    </a>
                    <a href="/exportToPDF" hidden>
                        <button>Export to PDF</button>
                    </a>
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        @if(Auth::user()->role == 'admin')
                            <thead>
                            <tr>
                                <th>Merchant Name</th>
                                <th>Transmission Date Time</th>
                                <th>Card Type</th>
                                <th>Ref Transaction</th>
                                <th>Approval Code</th>
                                <th>Amount</th>
                                <th>Card Number</th>
                                <th>MID</th>
                                <th>TID</th>
                                <th>Settle Response Code</th>
                                <th>Description</th>
                                <th>Transaction Type</th>
                                <th>Card Brand</th>
                                <th>System Trace Audit Number</th>
                                <th>Retrieval Reference Number</th>
                                <th>Merchant Code</th>
                                <th>Show in Map</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($transaction as $transaction)
                                <tr class="gradeA">
                                    <td>
                                        {{$transaction->merchant_name}}
                                    </td>
                                    <td>
                                        {{$transaction->transmission_date_time}}
                                    </td>
                                    <td>
                                        {{$transaction->card_type}}
                                    </td>
                                    <td>
                                    <a href="{{ url('/receipt/' . $transaction->name) }}"> {{ $transaction->name }}</a>
                                    </td>
                                    <td>
                                        {{$transaction->approval_code}}
                                    </td>
                                    <td>
                                    <?php
                                            $amount = number_format($transaction->amount,2,',','.');
                                            ?>
                                         RP : {{$amount}}
                                    </td>
                                    <td>
                                        {{$transaction->card_number}}
                                    </td>
                                    <td>
                                        {{$transaction->mid}}
                                    </td>
                                    <td>
                                        {{$transaction->tid}}
                                    </td>
                                    @if($transaction->settle_response_code=="0")
                                        <td>
                                            Settlement Approved
                                        </td>
                                    @endif
                                    @if($transaction->settle_response_code != "0")
                                        <td>
                                            Settlement Pending
                                        </td>
                                    @endif
                                    <td>
                                        {{$transaction->response_description}}
                                    </td>
                                    <td>
                                        {{$transaction->transaction_type}}
                                    </td>
                                    <td>
                                        {{$transaction->card_brand}}
                                    </td>
                                    <td>
                                        {{$transaction->system_trace_audit_number}}
                                    </td>
                                    <td>
                                        {{$transaction->retrieval_reference_number}}
                                    </td>
                                    <td>
                                        {{$transaction->merchant_code}}
                                    </td>
                                    <td>
                                        <a href="{{ url('/map/' . $transaction->name) }}"> Press</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        @endif
                        @if(Auth::user()->role == 'merchant')
                                <thead>
                                <tr>
                                    <th>Merchant Name</th>
                                    <th>Transmission Date Time</th>
                                    <th>Card Type</th>
                                    <th>Ref Transaction</th>
                                    <th>Approval Code</th>
                                    <th>Amount</th>
                                    <th>Card Number</th>
                                    <th>MID</th>
                                    <th>TID</th>
                                    <th>Description</th>
                                    <th>Settle Response Code</th>
                                    <th>Transaction Type</th>
                                    <th>Card Brand</th>
                                    <th>System Trace Audit Number</th>
                                    <th>Retrieval Reference Number</th>
                                    <th>Merchant Code</th>
                                    <th>Show in Map</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transaction as $transaction)
                                    <tr class="gradeA">
                                        <td>
                                            {{$transaction->merchant_name}}
                                        </td>
                                        <td>
                                            {{$transaction->transmission_date_time}}
                                        </td>
                                        <td>
                                            {{$transaction->card_type}}
                                        </td>
                                        <td>
                                            {{$transaction->name}}
                                        </td>
                                        <td>
                                            {{$transaction->approval_code}}
                                        </td>
                                        <td>
                                            <?php
                                            $amount = number_format($transaction->amount,2,',','.');
                                            ?>
                                            {{$amount}}
                                        </td>
                                        <td>
                                            {{$transaction->card_number}}
                                        </td>
                                        <td>
                                            {{$transaction->mid}}
                                        </td>
                                        <td>
                                            {{$transaction->tid}}
                                        </td>
                                        <td>
                                            {{$transaction->response_description}}
                                        </td>
                                        @if($transaction->settle_response_code=="0")
                                        <td>
                                            Settlement Approved
                                        </td>
                                        @endif
                                        @if($transaction->settle_response_code != "0")
                                            <td>
                                                Settlement Pending
                                            </td>
                                        @endif
                                        <td>
                                            {{$transaction->transaction_type}}
                                        </td>
                                        <td>
                                            {{$transaction->card_brand}}
                                        </td>
                                        <td>
                                            {{$transaction->system_trace_audit_number}}
                                        </td>
                                        <td>
                                            {{$transaction->retrieval_reference_number}}
                                        </td>
                                        <td>
                                            {{$transaction->merchant_code}}
                                        </td>
                                        <td>
                                            <a href="{{ url('/map/' . $transaction->name) }}"> Press</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                        @endif
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
@endsection