<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestAlumni extends Model
{
    protected $table = 'guest_alumnis';
    protected $fillable = [
        'name',
        'graduation_year',
        'major',
        'phone',
        'email',
        'purpose',
        'signature_path',
        'created_at',
    ];

    public $timestamps = false;
}
