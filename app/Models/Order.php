<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'order_status_id',
        'products_id'
    ];


    public function orderStatus(){
        $this->belongsTo(OrderStatus::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class, 'products_orders')->withPivot('quantity');
    }

    public function users(){
        return $this->belongsTo(User::class);
    }
}
