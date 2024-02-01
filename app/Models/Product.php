<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'products';
    protected $fillable = [
        'title',
        'category_id',
        'primary_image',
        'description',
        'price',
        'quantity',
        'delivery_amount'
    ];
    public function images()
    {
        return $this->hasMany(ProductImages::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
