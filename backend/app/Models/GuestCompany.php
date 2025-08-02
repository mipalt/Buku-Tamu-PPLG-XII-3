<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestCompany extends Model
{
    protected $table = 'guest_companies';
    protected $fillable = [
        'name',
        'industry',
        'company_name',
        'phone',
        'email',
        'purpose',
        'signature_path',
        'created_at',
    ];

    public $timestamps = false;
}
