<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ObjetoRobado;
use App\Models\Delito;
use App\Models\CoordenadasGeograficas;
use App\Models\Localidad;
use App\Models\Zona;
use App\Models\RegistroDelito;

class Formulario extends Controller
{
    public function objetoRobado()
    {
        $objetos = ObjetoRobado::select('id', 'nombre')->get(); // Obtiene las opciones
        $delitos = Delito::select('id', 'nombre')->get(); 

        return view('formulario', compact('delitos','objetos'));

    }

    public function guardarUbicacionDelito(Request $request)
    {
       // Definir límites geográficos de las zonas
    $zonas = [
        'norte' => [
            'lat_min' => -32.9329,
            'lat_max' => -32.8767,
            'lng_min' => -60.7235,
            'lng_max' => -60.6723,
        ],
        'sur' => [
            'lat_min' => -33.0141,
            'lat_max' => -32.9823,
            'lng_min' => -60.6881,
            'lng_max' => -60.6208,
        ],
        'centro' => [
            'lat_min' => -32.9822,
            'lat_max' => -32.9330,
            'lng_min' => -60.6681,
            'lng_max' => -60.6270,
        ],
        'oeste' => [
            'lat_min' => -32.9823,
            'lat_max' => -32.9330,
            'lng_min' => -60.7188,
            'lng_max' => -60.6680,
        ],
    ];

    $latitud = floatval($request->input('latitud'));
    $longitud = floatval($request->input('longitud'));
    $localidadNombre = $request->input('localidad'); // Ejemplo: "Rosario"
    $fecha = $request->input('fecha');
    $hora = $request->input('hora');
    $delitoId = $request->input('delitos');
    $objetoRobadoId = $request->input('objeto_robado');
    $detalles = $request->input('detalles');
    $userId = auth()->id(); // Obtener el ID del usuario autenticado

    $zonaNombre = null;

    // Identificar la zona según las coordenadas
    foreach ($zonas as $nombre => $limites) {
        if (
            $latitud >= $limites['lat_min'] && $latitud <= $limites['lat_max'] &&
            $longitud >= $limites['lng_min'] && $longitud <= $limites['lng_max']
        ) {
            $zonaNombre = $nombre;
            break;
        }
    }

    if ($zonaNombre) {
        // Verificar si ya existe la localidad con el mismo nombre
        $localidad = Localidad::firstOrCreate([
            'nombre' => $localidadNombre,
        ]);
    
        // Verificar si ya existe la zona con el mismo nombre y asignarla a la localidad
        $zona = Zona::firstOrCreate([
            'nombre' => ucfirst($zonaNombre), // Ejemplo: "Norte"
            'fk_localidad' => $localidad->id,
        ]);
    
        // Verificar si ya existen las coordenadas asociadas a la zona
        $coordenadas = CoordenadasGeograficas::firstOrCreate([
            'latitud' => $latitud,
            'longitud' => $longitud,
            'fk_zona' => $zona->id,
        ]);

        // Crear el registro del delito
        RegistroDelito::create([
            'fk_users' => $userId,
            'fk_tipoDelito' => $delitoId,
            'fk_objetoRobado' => $objetoRobadoId,
            'fecha' => $fecha,
            'hora' => $hora,
            'fk_ubicacion' => $localidad->id,
            'detalles' => $detalles,
        ]);

        return back()->with('success', 'Datos guardados correctamente.');
    } else {
        return back()->withErrors('No se pudo determinar la zona para esta ubicación.');
    }
 }
}