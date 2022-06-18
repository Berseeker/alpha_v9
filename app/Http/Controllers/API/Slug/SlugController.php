<?php

namespace App\Http\Controllers\API\Slug;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Producto;
use App\Models\Slug;

class SlugController extends Controller
{
    public function categoriaSlug(){
        $categorias = Categoria::all();
        foreach ($categorias as $categoria) {
            $slug = Str::slug($categoria->nombre, '-');
            $prevSlug = Slug::where('slug',$slug)->get();
            if($prevSlug->isEmpty())
            {
                $item = new Slug();
                $item->original_name = $categoria->nombre;
                $item->slug = $slug;
                $item->fk_id = $categoria->id;
                $item->path = "categoria";
                $item->created_at = now();
                $item->updated_at = now();
                $item->save();
            }
            
        }
        return response()->json([
            'status' => 'success',
            'msg' =>  "Slugs de categorias creados exitosamente"
        ]);
    }

    public function subcategoriaSlug(){
        $subcategorias = Subcategoria::all();
        foreach ($subcategorias as $subcategoria) {
            $slug = 'sub-'.Str::slug($subcategoria->nombre, '-');
            $prevSlug = Slug::where('slug',$slug)->get();
            if($prevSlug->isEmpty())
            {
                $item = new Slug();
                $item->original_name = $subcategoria->nombre;
                $item->slug = $slug;
                $item->fk_id = $subcategoria->id;
                $item->path = "subcategoria";
                $item->created_at = now();
                $item->updated_at = now();
                $item->save();
            }
        }
        return response()->json([
            'status' => 'success',
            'msg' =>  "Slugs de subcategorias creados exitosamente"
        ]);
    }

    public function productoSlug(){
        $productos = Producto::all();
        foreach ($productos as $producto) {
            $slug = Str::slug($producto->nombre." ".$producto->modelo, '-');
            $prevSlug = Slug::where('slug',$slug)->get();
            if($prevSlug->isEmpty())
            {
                $item = new Slug();
                $item->original_name = $producto->nombre;
                $item->slug = $slug;
                $item->fk_id = $producto->id;
                $item->path = "producto";
                $item->created_at = now();
                $item->updated_at = now();
                $item->save();
            }
        }

        return response()->json([
            'status' => 'success',
            'msg' =>  "Slugs de productos creados exitosamente"
        ]);
    }
}
