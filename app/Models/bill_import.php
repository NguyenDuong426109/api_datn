<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class bill_import extends Model
{
    use HasFactory;
    protected $table='bill_import';

    public function bill_import_det() {
        return $this->hasmany(bill_import_detail::class,'bill_import_id','id');
    }
    protected $fillable = [
        'producer_name',
        'adress',
        'phone',
    ];
}
