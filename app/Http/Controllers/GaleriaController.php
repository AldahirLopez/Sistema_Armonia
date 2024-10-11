<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estacion;
use Illuminate\Support\Facades\Storage;

class GaleriaController extends Controller
{


    public function store(Request $request, Estacion $estacion)
    {

        $num_estacion = $estacion->num_estacion;
        $categoria = $request->input('categoria');
        $imagenes = $request->file('imagenes');

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

    public function show($id_estacion)
    {
        //Vamos a poner los tipos dentro de la galeria
        $categorias_imagen = [
            '005',
            'Anexo',
            'Anuncio luminario',
            'Bombas',
            'Generales',
            'Inspectores',
            'Tanques'
        ];

        $estacion = Estacion::findOrFail($id_estacion);
        return view('armonia.estacion.galeria.show', compact('estacion', 'categorias_imagen'));
    }


    public function mostrarImagenes($estacion, $categoria)
    {
        // Define la carpeta donde están las imágenes
        $carpetaImages = "Estaciones/{$estacion}/Imagenes/{$categoria}";

        // Verifica si la carpeta existe y obtén las imágenes
        $imagenes = Storage::disk('public')->exists($carpetaImages)
            ? Storage::disk('public')->files($carpetaImages)
            : [];

        // Genera la información para cada imagen
        $imagenes_data = array_map(function ($imagen) use ($categoria) {
            return [
                'nombre' => basename($imagen), // Obtiene solo el nombre del archivo
                'url' => Storage::url($imagen), // Obtiene la URL pública de la imagen
                'categoria' => $categoria // Incluye la categoría
            ];
        }, $imagenes);

        // Retorna la respuesta en formato JSON
        return response()->json($imagenes_data);
    }

    public function destroy(Request $request, $num_estacion, $categoria)
    {
        // Verificar el valor recibido
        $imagen = $request->input('imagen');

        // Asegurarse de que estamos recibiendo una cadena, no un array
        if (is_array($imagen)) {
            return response()->json(['message' => 'Se ha recibido un array en lugar de una cadena para la imagen'], 400);
        }

        if (empty($imagen)) {
            return response()->json(['message' => 'No se ha proporcionado ninguna imagen'], 400);
        }

        // Extraer solo la parte relevante de la URL (la ruta dentro de storage/app/public)
        $rutaImagen = str_replace('/storage', '', parse_url($imagen, PHP_URL_PATH));

        // Verificar si el archivo existe en el disco 'public'
        if (Storage::disk('public')->exists($rutaImagen)) {
            Storage::disk('public')->delete($rutaImagen);
            return response()->json(['message' => 'Imagen eliminada correctamente']);
        }

        return response()->json(['message' => 'La imagen no existe'], 404);
    }
}
