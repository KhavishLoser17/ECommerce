<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\OrderItem;


class Order extends Model
{
    use HasFactory;


    protected $table = 'orders';
    protected $casts = [
    'order_date' => 'datetime',
    ];

    // Mass assignable attributes
    protected $fillable = [
        'order_number',
        'user_id',
        'student_id',
        'student_name',
        'product_name',       // Added Product Name
        'course_uniform',     // Added Course Uniform
        'quantity',           // Added Quantity
        'total',
        'payment_method',
        'order_date',
        'receipt',
        'status',
    ];



    // Relationship: An order belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship: An order has many order items
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Accessor for formatted total (e.g., ₱1,234.56)
    public function getFormattedTotalAttribute()
    {
        return '₱' . number_format($this->total, 2);
    }

    // Mutator to format order date
    public function setOrderDateAttribute($value)
    {
        $this->attributes['order_date'] = date('Y-m-d', strtotime($value));
    }
}
