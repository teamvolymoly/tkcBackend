<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactQuery extends Model
{
    protected $fillable = [
        'company_name',
        'name',
        'email',
        'phone_number',
        'comment',
        'phone',
        'subject',
        'message',
    ];

    protected $hidden = [
        'phone',
        'subject',
        'message',
    ];
}
