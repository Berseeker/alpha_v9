<?php

namespace App\Http\Controllers\WEB\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;


class LineaAlphaController extends Controller
{
    public function displays()
    {
        $categorias = Categoria::all();
        $pageConfigs = [
          'contentLayout' => "content-detached-left-sidebar",
          'bodyClass' => 'ecommerce-application',
        ];

        return view('Home.displays',[
            'pageConfigs' => $pageConfigs,
            'categorias' => $categorias,
            'cont' => 1
        ]);
    }

    public function hats()
    {
        $categorias = Categoria::all();
        $pageConfigs = [
          'contentLayout' => "content-detached-left-sidebar",
          'bodyClass' => 'ecommerce-application',
        ];

        return view('Home.linea_alpha',[
            'pageConfigs' => $pageConfigs,
            'cont' => 1,
            'categorias' => $categorias
        ]);
    }
}
