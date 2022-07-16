<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use Laravel\Scout\Searchable;

class Producto extends Model
{
    use HasFactory,SoftDeletes,Searchable;

    protected $table = 'productos';

    protected $fillable = [
        'SDK','nombre', 'nickname','descripcion','images','color','proveedor','piezas_caja','area_impresion','metodos_impresion','peso_caja','medida_producto_ancho','medida_producto_alto','medidas_producto_general','alto_caja','ancho_caja','largo_caja','caja_master','modelo','material','capacidad','promocion','file_name','custom','categoria_id','subcategoria_id','busqueda'
    ];

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
        $img = '/imgs/no_disp.png';
        if($this->images != null)
        {
            $img = json_decode($this->images)[0];
            if(!Str::contains($img,['https','http']))
            {
                $img = Storage::url($img);
            }
        }

        return [
            'busqueda' => $this->busqueda,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'img' => $img
        ];
    }
}
