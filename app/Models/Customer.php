<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table='customer';
    public function oder() {
        return $this->belongsTo(oder::class);
    }
    protected $fillable = [
        'name',
        'adress',
        'email',
        'phone',
        'order_id'

    ];
}
