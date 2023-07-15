<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function shippment() {
        return $this->belongsTo(Shippment::class);
    }

    public function seller() {
        return $this->belongsTo(User::class);
    }

    public function payment() {
        return $this->belongsTo(Payment::class);
    }
}
