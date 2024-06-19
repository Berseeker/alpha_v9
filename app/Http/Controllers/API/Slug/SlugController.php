<?php

namespace App\Http\Controllers\API\Slug;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Subcategoria;
use App\Models\Categoria;
use App\Models\Product;
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
            $slug = Str::slug($subcategoria->categoria->nombre, '-') . '-'.Str::slug($subcategoria->nombre, '-');
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
        $productos = Product::all();
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

    public function productoV2Slug(){
        $productos = Product::all();
        foreach ($productos as $producto) {
            $slug = Str::slug($producto->name." ".$producto->code, '-');
            $prevSlug = Slug::where('slug',$slug)->get();
            if($prevSlug->isEmpty())
            {
                $item = new Slug();
                $item->original_name = $producto->name;
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

    public function correctSlug()
    {
        $all_slugs = Slug::where('path', 'producto')->get();
        foreach ($all_slugs as $slug) {
            $producto = Product::where('name', $slug->original_name)->first();
            $slug = Slug::where('original_name', $producto->name);
            if ($slug->fk_id != $producto->id) {
                $slug->fk_id = $producto->id;
                $slug->save();
            }
        }
    }
}
