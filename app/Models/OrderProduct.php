<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "order_x_product";

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }
}
