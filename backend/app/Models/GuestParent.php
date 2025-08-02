<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuestParent extends Model
{
    protected $table = 'guest_parents';
    protected $fillable = [
        'name',
        'student_name',
        'rayon',
        'address',
        'phone',
        'email',
        'purpose',
        'signature_path',
        'created_at',
    ];
}
