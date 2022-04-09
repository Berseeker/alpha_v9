<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'cotizaciones';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
