<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Subcategoria extends Model
{
    use HasFactory,Searchable,SoftDeletes;

    public function searchableAs()
    {
        return 'subcategorias_index';
    }
}
