<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'SDK','nombre', 'nickname','descripcion','images','color','proveedor','piezas_caja','area_impresion','metodos_impresion','peso_caja','medida_producto_ancho','medida_producto_alto','medidas_producto_general','alto_caja','ancho_caja','largo_caja','caja_master','modelo','material','capacidad','promocion','file_name','custom','categoria_id','subcategoria_id','busqueda'
    ];
}
