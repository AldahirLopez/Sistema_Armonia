<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estacion;
use Illuminate\Support\Facades\Storage;
class GaleriaController extends Controller
{
   

    public function store(Request $request,Estacion $estacion){ 
       
        $num_estacion=$estacion->num_estacion;
        $categoria=$request->input('categoria');
        $imagenes=$request->file('imagenes');

        $carpetaImages = "Estaciones/{$num_estacion}/Imagenes/{$categoria}";
        
        if (!Storage::disk('public')->exists($carpetaImages)) {
            Storage::disk('public')->makeDirectory($carpetaImages);
        }

        foreach ($imagenes as $imagen) {
            $nombreimagen = $imagen->getClientOriginalName();
            $imagen->storeAs($carpetaImages, $nombreimagen, 'public');
        }

        return redirect()->route('galeria.show', ['id_estacion' => $estacion->id])->with('success', 'Imagenes subidas correctamente'); 
    
    }

    public function show($id_estacion){
        //Vamos a poner los tipos dentro de la galeria
          $categorias_imagen=[
                '005',
                'Anexo',
                'Anuncio luminario',
                'Bombas',
                'Generales',
                'Inspectores',
                'Tanques'
            ];  

        $estacion=Estacion::findOrFail($id_estacion);
        return view('armonia.estacion.galeria.show',compact('estacion','categorias_imagen'));
    }

    public function mostrarImagenes($estacion,$categoria){
   
        
        $carpetaImages = "Estaciones/{$estacion}/Imagenes/{$categoria}";

        $imagenes = Storage::disk('public')->exists($carpetaImages)
        ? Storage::disk('public')->files($carpetaImages)
        : [];
    
        $imagenes_urls = array_map(function ($imagen) use ($carpetaImages) {
            return asset("storage/{$imagen}");
        }, $imagenes);

        return response()->json($imagenes_urls);
        
    }




}
