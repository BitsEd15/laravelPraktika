<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart_item extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'items_quantity'
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
