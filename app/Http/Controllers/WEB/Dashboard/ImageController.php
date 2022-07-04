<?php

namespace App\Http\Controllers\WEB\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Imagen;
use Illuminate\Support\Facades\Storage;


class ImageController extends Controller
{
    public function index(){
        //$imagen =  Imagen::where('nombre','=','perritos.png')->get();
        //$imagen =  Imagen::all();
        
        return view("dashboard.images.index");
    }

    public function store( Request $request ){
        $rules = [
            'fileToUpload' => 'required|image|mimes:jpg,png,jpeg' 
        ];

        $messages = [
            'fileToUpload.required' => 'Es necesaria una imagen',
            'fileToUpload.image' => 'Tipo de archivo no valido',
            'fileToUpload.mimes' => 'Extension de imagen no valida'
        ];
        
        $this->validate($request, $rules, $messages);


        $name = $request->file('fileToUpload')->getClientOriginalName();
 
        $path = $request->file('fileToUpload')->store('public/images_slider');

        $imagen = new Imagen();
        $imagen->nombre = $name;
        $imagen->path = $path;
        $imagen->seccion = $request->secciones;

        if ($request->has('titulo')) {
            $imagen->titulo = $request->titulo;
        }
        if ($request->has('parrafo')) {
            $imagen->parrafo = $request->parrafo;
        }
        if ($request->has('pdf')) {
            $path = $request->file('pdf')->store('public/catalogos');
            $imagen->pdf = $path;
        }
        $imagen->save();
        return back()->with('success',"Imagen subida correctamente");
        
    }

    public function edit(){

        $imagen =  Imagen::all();
        return view("dashboard.images.show",[
            'clonazepan' => $imagen
        ]);
    }

    public function delete( $id){
        
        $imagen =  Imagen::find($id);
        $validator = Imagen::where('seccion', '=', $imagen->seccion)->get();
        
        //dd($imagen);
        if($imagen ==null){
            return back()->with('warning',"Imagen no encontrada");
        }
        if( count($validator) <= 1 ){
            return back()->with('warning',"NO puede quedarse sin imagenes");
        }
        if ($imagen->seccion == 'catalogos') {
            Storage::delete($imagen->pdf);
        }
        Storage::delete($imagen->path);
        $imagen->delete();
        return back()->with('success',"Imagen Borrada Exitosamente");
    }


    public function update( Request $request, $id)
    {
        //dd($request->all());
        $imagen = Imagen::find($id);
        if($request->has('nombre')){
            $imagen->nombre = $request->name;
        }

        if($request->has('nueva_imagen')){
            $path = $request->file('nueva_imagen')->store('public/images_slider');
            Storage::delete($imagen->path);
            $imagen->path = $path;
        }

        if ($request->has('titulo')) {
            $imagen->titulo = $request->titulo;
        }
        if ($request->has('parrafo')) {
            $imagen->parrafo = $request->parrafo;
        }
        if ($request->has('nuevo_pdf')) {
            if($imagen->pdf != null){
                Storage::delete($imagen->pdf);
            }
            $path = $request->file('nuevo_pdf')->store('public/catalogos');
            $imagen->pdf = $path;
            
        }
        $imagen->save();
        return back()->with('success',"Imagen editada correctamente");
    }
    
}
