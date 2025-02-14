<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'name',
        'slug',
        'description',
        'image',
        'is_active',
        'is_featured',
        'in_stock',
        'on_sale',
        'price',
        'brand_id',
        'category_id'
    ];
    protected $casts = [
        'image' => 'array'
    ];
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orderItems(){
        return $this->hasMany(OrderItem::class);
    }
}
