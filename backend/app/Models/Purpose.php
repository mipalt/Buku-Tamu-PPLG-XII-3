<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    protected $fillable = [
        'purpose',
        'visitor_id',
        'guest_type'
    ];

    public function company()
    {
        return $this->morphTo(__FUNCTION__, 'guest_type', 'visitor_id');
    }

    // public function visitor()
    // {
    //     return $this->morphTo(__FUNCTION__, 'guest_type', 'visitor_id');
    // }

    // di model
    // public function purposes()
    // {
    //     return $this->morphMany(Purpose::class, 'visitor', 'guest_type', 'visitor_id');
    // }

}
