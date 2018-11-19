<div class="panel-body">
    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" border="1">
        <thead>
        <tr>
            <th>Merchant Name</th>
            <th>Transmission Date Time</th>
            <th>Card Type</th>
            <th>Ref Transaction</th>
            <th>Approval Code</th>
            <th>Card Number</th>
            <th>MID</th>
            <th>TID</th>
            <th>Description</th>
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
                    {{$transaction->name }}
                </td>
                <td>
                    {{ $transaction->approval_code }}
                </td>
                <td>
                    {{ $transaction->card_number }}
                </td>
                <td>
                    {{ $transaction->mid }}
                </td>
                <td>
                    {{ $transaction->tid }}
                </td>
                <td>
                    {{ $transaction->response_description }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>