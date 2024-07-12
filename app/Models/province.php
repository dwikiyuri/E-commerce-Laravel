<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class province extends Model
{
    use HasFactory;
    protected $table = 'province';
    protected $primaryKey = 'province_code';
    protected $fillable = [
        'province_name',
        'province_code',
        'province_name_en'
    ];
    public function subProvinces()
    {
        return $this->hasMany(subprovince::class);
    }

}
