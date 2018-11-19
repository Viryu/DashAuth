<?php

namespace App\Exports;

use App\DataTable;
use App\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ExportAll implements FromQuery, WithStrictNullComparison,WithHeadings
{
    use Exportable;

    public function headings(): array
    {
        return [
            'merchant_name',
            'transmision_date_time',
            'amount',
            'card_type',
            'card_onus',
            'response_code',
            'response_description',
            'approval_code',
            'card_number',
            'mid',
            'tid',
            'authorisation_response_code',
            'settle_response_code',
            'transaction_type',
            'card_brand',
            'system_trace_audit_number',
            'retrieval_reference_number',
            'merchant_code',
            'billing_address_state',
            'billing_address_city',
            'merchant_type',
            'industry',
            'billing_address_street',
            'account_number',
            'merchant_bank',
            'longitude',
            'latitude',
            'ip_address',
        ];
    }
    public function query()
    {
        if(Auth::user()->role == "admin"){
            return DataTable::query()
                ->select('merchant_name','transmission_date_time','amount',
                    'card_type',
                    'card_onus',
                    'response_code',
                    'response_description',
                    'approval_code',
                    'card_number',
                    'mid',
                    'tid',
                    'authorisation_response_code',
                    'settle_response_code',
                    'transaction_type',
                    'card_brand',
                    'system_trace_audit_number',
                    'retrieval_reference_number',
                    'merchant_code',
                    'billing_address_state',
                    'billing_address_city',
                    'merchant_type',
                    'industry',
                    'billing_address_street',
                    'account_number',
                    'merchant_bank',
                    'longitude',
                    'latitude',
                    'ip_address')
                ->orderBy('merchant_name');
        }
        else{
            return DataTable::query()
                ->select('merchant_name','transmission_date_time','amount',
                    'card_type',
                    'card_onus',
                    'response_code',
                    'response_description',
                    'approval_code',
                    'card_number',
                    'mid',
                    'tid',
                    'authorisation_response_code',
                    'settle_response_code',
                    'transaction_type',
                    'card_brand',
                    'system_trace_audit_number',
                    'retrieval_reference_number',
                    'merchant_code',
                    'billing_address_state',
                    'billing_address_city',
                    'merchant_type',
                    'industry',
                    'billing_address_street',
                    'account_number',
                    'merchant_bank',
                    'longitude',
                    'latitude',
                    'ip_address')
                ->where('mid','=',Auth::user()->mid)
                ->orderBy('merchant_name');
        }

    }
}