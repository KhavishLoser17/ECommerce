<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\OrderItem;


class Product extends Model {
    use HasFactory;

    protected $fillable = [
       'product_id',
        'product_name',
        'course_uniform',
        'price',
        'description',
        'size_s',
        'size_m',
        'size_l',
        'size_xl',
        'size_xxl',
        'quantity',
        'main_image',
        'gallery_images',
    ];

    protected $casts = [
        'sizes' => 'array',
        'gallery_images' => 'array'
    ];


}
