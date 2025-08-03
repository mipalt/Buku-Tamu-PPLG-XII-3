<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table = 'guest_visitors';

    protected $fillable = [
        'name',
        'institution',
        'phone',
        'email',
        'purpose',
        'signature_path',
        'create_at'
    ];

    public $timetamps = false;
}
