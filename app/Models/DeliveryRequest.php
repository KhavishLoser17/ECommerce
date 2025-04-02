<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryRequest extends Model
{
    use HasFactory;
    protected $table = 'delivery_requests';

    protected $fillable = [
        'product_id',
        'supplier_name',
        'location',
        'delivery_date',
        'size_s',
        'size_m',
        'size_l',
        'size_xl',
        'size_xxl',
        'quantity',
        'note',
        'status',
        'rejection_cause',  // Added field
        'rejection_reason',
        'tracking_number',
    ];

            public function product()
        {
            return $this->belongsTo(Product::class, 'product_id', 'id');
        }

}
