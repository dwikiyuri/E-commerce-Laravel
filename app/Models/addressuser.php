<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class addressuser extends Model
{
    use HasFactory;
    protected $table = 'addressusers';
    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'street_address',
        'province',
        'city',
        'village',
        'village_district',
        'zip_code'
    ];

    public function addressuser(){
        return $this->belongsTo(User::class);
    }
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
