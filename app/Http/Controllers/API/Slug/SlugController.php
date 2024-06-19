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
        $count = 0;
        $all_slugs = Slug::where('path', 'producto')->get();
        $slugs_deleted = array();
        $slugs_exception = array();
        $product_exception = array();
        foreach ($all_slugs as $slug) {
            $producto = Product::where('name', $slug->original_name)->whereNull('deleted_at')->first();
            if ($producto == null) {
                $producto_trashed = Product::onlyTrashed()->where('name', $slug->original_name)->first();
                if ($producto_trashed != null) {
                    array_push($slugs_deleted, $slug);
                    $slug->delete();
                } else {
                    array_push($slugs_exception, $slug);
                    $slugs_exception
                }
            } else {
                $slug_find = Slug::where('original_name', $producto->name)->first();
                if ($slug_find == null) {
                    array_push($product_exception, $producto);
                } else {
                    if ($slug_find->fk_id != $producto->id) {
                        $slug_find->fk_id = $producto->id;
                        $slug_find->save();
                        $count++;
                    }
                }
            } 
        }

        return response()->json([
            'msg' => 'Se corrigieron los slugs',
            'count' => $count,
            'slugs_deleted' => $slugs_deleted,
            'slugs_exception' => $slugs_exception,
            'product_exception' => $product_exception
        ]);
    }
}
