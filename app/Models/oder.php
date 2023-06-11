<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class oder extends Model
{
    use HasFactory;
    protected $table='oder';

    public function oder_detail() {
        return $this->hasMany(oder_detail::class,'order_id');
    }
    public function Customer() {
        return $this->hasOne(Customer::class,'oder_id');
    }
    protected $fillable = [
        'order_code',
        'order_note',
        'totalMoney',
        'payment_status',
    ];
}
