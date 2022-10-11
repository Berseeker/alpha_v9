<?php

namespace App\Http\Controllers\WEB\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;

use SEOMeta;
use OpenGraph;
use JsonLd;
use Twitter;

class LineaAlphaController extends Controller
{
    public function displays()
    {
        $categorias = Categoria::all();
        $pageConfigs = [
          'contentLayout' => "content-detached-left-sidebar",
          'bodyClass' => 'ecommerce-application',
        ];

        SEOMeta::setTitle('Displays');
        SEOMeta::setDescription('Ponemos a tus órdenes nuestro servicio de diseño y armado de stands para tus expos, convenciones o eventos sociales con personal calificado y precios accesibles, solicita cotización.');
        SEOMeta::setCanonical('https://alphapromos.mx/displays/');

        OpenGraph::setDescription('Ponemos a tus órdenes nuestro servicio de diseño y armado de stands para tus expos, convenciones o eventos sociales con personal calificado y precios accesibles, solicita cotización.');
        OpenGraph::setTitle('Displays');
        OpenGraph::setUrl('https://alphapromos.mx/displays');
        OpenGraph::addProperty('type', 'displays');

        Twitter::setTitle('Displays');
        Twitter::setSite('@alphapromos');

        JsonLd::setTitle('Displays');
        JsonLd::setDescription('Ponemos a tus órdenes nuestro servicio de diseño y armado de stands para tus expos, convenciones o eventos sociales con personal calificado y precios accesibles, solicita cotización.');
        JsonLd::addImage('https://alphapromos.mx/imgs/displays/got.jpg');

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

        SEOMeta::setTitle('Liena Alpha');
        SEOMeta::setDescription('Ponemos a tus órdenes nuestro servicio de diseño y armado de stands para tus expos, convenciones o eventos sociales con personal calificado y precios accesibles, solicita cotización.');
        SEOMeta::setCanonical('https://alphapromos.mx/');

        OpenGraph::setDescription('Ponemos a tus órdenes nuestro servicio de diseño y armado de stands para tus expos, convenciones o eventos sociales con personal calificado y precios accesibles, solicita cotización.');
        OpenGraph::setTitle('Displays');
        OpenGraph::setUrl('https://alphapromos.mx/');
        OpenGraph::addProperty('type', 'displays');

        Twitter::setTitle('Displays');
        Twitter::setSite('@alphapromos');

        JsonLd::setTitle('Displays');
        JsonLd::setDescription('Ponemos a tus órdenes nuestro servicio de diseño y armado de stands para tus expos, convenciones o eventos sociales con personal calificado y precios accesibles, solicita cotización.');
        //JsonLd::addImage('https://laravelcode.com/frontTheme/img/logo.png');

        return view('Home.linea_alpha',[
            'pageConfigs' => $pageConfigs,
            'cont' => 1,
            'categorias' => $categorias
        ]);
    }
}
