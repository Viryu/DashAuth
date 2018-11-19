<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankCardCode extends Model
{
//    protected $fillable = [
//        'BIN','merchant_bank','Type'
//    ];
public $timestamps = false;

    //
    protected $table = "VDI_BankCardCode";
}
