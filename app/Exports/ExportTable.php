<?php

namespace App\Exports;

use App\DataTable;
use App\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ExportTable implements FromQuery, WithStrictNullComparison, WithHeadings
{
    use Exportable;
    public function conditionstotake($response_code,$argument,$authorisation_response_code,$argument2){
        $this->response_code = $response_code;
        $this->argument = $argument;
        $this->authorisation_response_code = $authorisation_response_code;
        $this->argument2 = $argument2;
        return $this;
    }
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
        if(Auth::user()->role =="admin"){
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
                ->where('response_code',$this->argument,$this->response_code)
                ->where( 'authorisation_response_code',$this->argument2, $this->authorisation_response_code)
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
                 ->where('response_code',$this->argument,$this->response_code)
                 ->where( 'authorisation_response_code',$this->argument2, $this->authorisation_response_code)
                 ->where('mid','=',Auth::user()->mid)
                 ->orderBy('merchant_name');
         }

    }
    public function queryall(){
        return DataTable::query();
    }
}