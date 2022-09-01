<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

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

        return [
            'busqueda' => $this->busqueda,
        ];
    }
}
