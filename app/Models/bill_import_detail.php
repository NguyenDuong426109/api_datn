<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bill_import_detail extends Model
{
    use HasFactory;
    protected $table='bill_import_details';
    // public function bill_import() {
    //     return $this->hasmany(bill_import_detail::class,);
    // }
    protected $fillable = [
        'bill_import_id',
        'product_id',
        'amount',
       
    ];
}
