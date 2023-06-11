<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Size;

class Product extends Model
{
    use HasFactory;
    protected $table='product';
    public function category() {
        return $this->belongsTo(Category::class,'categories_id');
    }
    public function size() {
        return $this->hasMany(Size::class,'product_id');
    }
    public function color() {
        return $this->hasMany(Color::class,'product_id');
    }
    public function image()
    {
        return $this->hasMany(img::class,'product_id');
    }
    protected $fillable = 
    [
        'name',
        'categories_id',
        'price',
        'description',
        'status',
    ];
}
