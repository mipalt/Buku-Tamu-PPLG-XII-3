<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestCompany extends Model
{
    use HasFactory;

    protected $table = 'guest_companies';

    protected $fillable = [
        'name',
        'company_name',
        'phone',
        'email',
        'signature_path',
    ];
    
    public function purposes()
    {
        return $this->morphOne(Purpose::class, 'visitor', 'guest_type', 'visitor_id');
    }

}

