@extends('layouts.dashboardHeader')
@section('content')
<meta name="viewport" content="width=device-width, initial-scale=1">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Failure Transactions
                    <a href="/exporterrorxls">
                        <button>Export to Excel (XLS)</button>
                    </a>
                    <a href="/exporterrorcsv">
                        <button>Export to Excel (CSV)</button>
                    </a>
                    <a href="/exportToPDFfail" hidden>
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