<?php

namespace App\Models;

use App\Models\province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use function Laravel\Prompts\select;

class subprovince extends Model
{
    use HasFactory;
    protected $table = 'subprovince';
    protected $fillable = [
        'urban',
        'sub_district',
        'city',
        'province_code',
        'postal_code'
    ];
    public function province()
    {
        return $this->belongsTo(province::class);
    }


}
