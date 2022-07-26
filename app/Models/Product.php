<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['name_ar', 'name_en', 'description_ar', 'description_en', 'image', 'category_id', 'purchase_price', 'sale_price', 'stock'];

    protected $appends = ['image_path'];

    public function getImagePathAttribute()
    {
        return asset('uploads/products_images/' . $this->image);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
