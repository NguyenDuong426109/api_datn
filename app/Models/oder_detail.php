<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class oder_detail extends Model
{
    use HasFactory;
    protected $table='oder_detail';

    public function product() {
        return $this->hasMany(Product::class,'id','product_id');
    }
    public function size() {
        return $this->hasMany(Size::class,'id','size_id');
    }
    public function color() {
        return $this->hasMany(Color::class,'id','color_id');
    }
    
    protected $fillable = [
        'order_id',
        'product_id',
        'size_id',
        'color_id',
        'quantity',
        'price',
        'img_oder'
    ];
}
