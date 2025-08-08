<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Parents extends Model
{
    //
    use HasFactory;
    protected $table = 'parents';
    protected $fillable = [
        'name',
        'student_name',
        'rayon',
        'address',
        'phone',
        'email',
        'signature_path',
    ];
    public $timestamps = false;

    public function purposes()
    {
        return $this->morphOne(Purpose::class, 'visitor', 'guest_type', 'visitor_id');
    }

}
