<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Categoria extends Model
{
    use HasFactory,Searchable,SoftDeletes;

    public function subcategorias(){
        return $this->hasMany(Subcategoria::class,'categoria_id')->orderBy('nombre');
    }

    public function customSubcategory() {
        return $this->hasMany(Subcategoria::class,'categoria_id')->limit(4);
    }

    public function subcategoria() {
        return $this->hasOne(Subcategoria::class,'categoria_id');
    }

    public function searchableAs()
    {
        return 'categorias_index';
    }
}
