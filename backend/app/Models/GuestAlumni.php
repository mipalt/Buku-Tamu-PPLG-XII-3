<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestAlumni extends Model
{
    use HasFactory;

    protected $table = 'guest_alumni';

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
