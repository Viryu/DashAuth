<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankTransactionCount extends Model
{
    protected $fillable = [
        'id','merchant_bank','card_type','transaction_count','mid'
    ];
public $timestamps = false;
    //
    protected $table = "dm_bank_transaction_count";
}
