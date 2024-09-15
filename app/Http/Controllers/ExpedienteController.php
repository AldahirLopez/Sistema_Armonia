<?php

namespace App\Http\Controllers;

use App\Models\Estados\Estados;
use App\Models\ServicioAnexo;
use App\Models\Estacion;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    public function index($id)
    {
        // Obtener el servicio por su ID
        $servicioAnexo = ServicioAnexo::findOrFail($id);

        // Recuperar la(s) estación(es) relacionada(s) usando la tabla intermedia 'estacion_servicio'
        $estaciones = $servicioAnexo->estaciones()->get();

        // Verificar si se encontró alguna estación relacionada
        if ($estaciones->isEmpty()) {
            return redirect()->back()->with('error', 'No se encontraron estaciones relacionadas para este servicio.');
        }

        // Si solo quieres la primera estación (ajusta según tus necesidades)
        $estacion = $estaciones->first();

        // Obtener la lista de estados
        $estados = Estados::all();

        // Obtener archivos existentes (modifica según tu lógica)
        $existingFiles = []; // Aquí debes agregar tu lógica para los archivos existentes

        // Pasar los datos a la vista
        return view('armonia.servicios.anexo_30.expediente.generarExpediente', compact('servicioAnexo', 'estacion', 'estados', 'existingFiles'));
    }

    public function generarExpediente(Request $request)
    {
        // Paso 1: Validar los datos del formulario
        $validatedData = $request->validate([
            'nomenclatura' => 'required|string',
            'idestacion' => 'required|integer|exists:estacion,id', // Validar que la estación existe en la base de datos
            'id_servicio' => 'required|integer|exists:servicio_anexo_30,id',
            'id_usuario' => 'required|integer|exists:users,id', // Validar que el usuario existe
            'numestacion' => 'required|string',
            'tipo_estacion' => 'required|string',
            'num_estacion' => 'required|string',
            'razon_social' => 'required|string',
            'rfc' => 'required|string',
            'estado_republica' => 'required|string',
            'num_cre' => 'nullable|string',
            'num_constancia' => 'nullable|string',
            'fecha_recepcion' => 'required|date',
            'telefono' => 'nullable|string',
            'correo_electronico' => 'nullable|email',
            'contacto' => 'nullable|string',
            'nombre_representante_legal' => 'nullable|string',
            'domicilio_fiscal_id' => 'nullable|integer',
            'domicilio_servicio_id' => 'nullable|integer',
            'fecha_inspeccion' => 'required|date',
        ]);

        // Paso 2: Obtener los datos validados
        $nomenclatura = $validatedData['nomenclatura'];
        $idestacion = $validatedData['idestacion'];
        $idServicio = $validatedData['id_servicio'];
        $idUsuario = $validatedData['id_usuario'];
        $numEstacion = $validatedData['numestacion'];
        $tipoEstacion = $validatedData['tipo_estacion'];
        $razonSocial = $validatedData['razon_social'];
        $rfc = $validatedData['rfc'];
        $estadoRepublica = $validatedData['estado_republica'];
        $numCRE = $validatedData['num_cre'];
        $numConstancia = $validatedData['num_constancia'];
        $fechaRecepcion = $validatedData['fecha_recepcion'];
        $telefono = $validatedData['telefono'];
        $correoElectronico = $validatedData['correo_electronico'];
        $contacto = $validatedData['contacto'];
        $nombreRepresentante = $validatedData['nombre_representante_legal'];
        $domicilioFiscalId = $validatedData['domicilio_fiscal_id'];
        $domicilioServicioId = $validatedData['domicilio_servicio_id'];
        $fechaInspeccion = $validatedData['fecha_inspeccion'];

        // Paso 3: Aquí puedes continuar con la lógica para manejar los datos, como generar el expediente, documentos o almacenarlos.

        return response()->json([
            'message' => 'Datos recibidos correctamente',
            'data' => $validatedData
        ]);
    }
}
