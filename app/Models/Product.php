<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable=[
        'productStatus',
        'productName',
        'productDescription',
        'price',
        'stock',
        'category_id',
        'sub_category_id',
        'promotion_id',
        'size_id',
        'collection_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function promotion(){
        return $this->belongsTo(Promotion::class);
    }

    public function subCategory(){
        return $this->belongsTo(SubCategory::class);
    }

    public function size(){
        return $this->belongsTo(Size::class);
    }

    public function collection(){
        return $this->belongsTo(Collection::class);
    }

    public function orders(){
        return $this->BelongsToMany(Order::class);
    }

}
