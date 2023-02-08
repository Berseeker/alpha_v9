<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory, Searchable;

    protected $table = 'products';

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        // Applies Scout Extended default transformations:
        $array = $this->transform($array);

        // Add an extra attribute:
        $array['categoria_name'] = $this->categoria->nombre;
        $array['subcategoria_name'] = $this->subcategoria->nombre;
        $img = asset('imgs/v3/productos/no_disp.png');
        if($this->images != null)
        {
            $img = json_decode($this->images)[0];
            if(!Str::contains($img,['https','http']))
            {
                $img = Storage::disk('doblevela_img')->url($img);
            }
        }
        $array['img'] = $img;

        $colors = '';
        $colores = json_decode($this->colors);
        if (count($colores) > 0) {
            foreach ($colores as $color) {
                $colors = $colors . ' '. $color;
            }
        } else {
            $colors = 'Sin especificar';
        }

        $array['colores'] = $colors;

        $metodos_impresion = '';
        $impresiones = json_decode($this->printing_methods);
        if (count($impresiones) > 0) {
            foreach ($impresiones as $impresion) {
                $metodos_impresion = $metodos_impresion . ' ' . $impresion;
            }
        } else {
            $metodos_impresion = "Sin especificar";
        }

        $array['metodos_impresion'] = $metodos_impresion;

        return $array;
    }
}
