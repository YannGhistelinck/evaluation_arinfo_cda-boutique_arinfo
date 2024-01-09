<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


    public function orderStatus(){
        $this->belongsTo(OrderStatus::class);
    }

    public function products(){
        return $this->belongsToMany(Product::class);
    }

    public function users(){
        return $this->belongsTo(User::class);
    }
}
