<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLoginHistory extends Model
{
    protected $fillable = [
        'email','ip_address'
    ];

    protected $table = 'vdi_user_login_histories';
}
