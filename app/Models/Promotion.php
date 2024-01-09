<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory;

    public function promotionType(){
        return $this->belongsTo(PromotionType::class);
    }

    public function pruducts(){
        return $this->hasMany(Product::class);
    }
}
