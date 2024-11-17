<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeatMapCalor extends Controller
{
    public function index(Request $request)
    {

      // Capturar filtros
    $zona = $request->input('zona');
    $localidad = $request->input('localidad');
    $horaMinima = $request->input('hora_minima');
    $horaMaxima = $request->input('hora_maxima');

    //dd($zona, $localidad, $horaMinima, $horaMaxima);

    // Construir la consulta base
    $query = DB::table('registro_de_delitos')
        ->join('localidad', 'registro_de_delitos.fk_ubicacion', '=', 'localidad.id')
        ->join('zona', 'zona.fk_localidad', '=', 'localidad.id')
        ->join('coordenadas_geograficas', 'coordenadas_geograficas.fk_zona', '=', 'zona.id')
        ->select(
            'coordenadas_geograficas.latitud as lat',
            'coordenadas_geograficas.longitud as lng',
            DB::raw('COUNT(registro_de_delitos.id) as count')
        );

        
    // Aplicar filtros dinámicos
    if ($zona) {
        $query->where('zona.nombre', $zona);
        //dd($zona);
    }
    if ($localidad) {
        $query->where('localidad.nombre', $localidad);
        //dd($localidad);
    }
    if ($horaMinima && $horaMaxima) {
        $query->whereBetween('registro_de_delitos.hora', [$horaMinima, $horaMaxima]);
        //dd($horaMaxima, $horaMinima);
    }

    // Ejecutar la consulta y obtener los datos
    $heatmapData = $query
        ->groupBy('coordenadas_geograficas.latitud', 'coordenadas_geograficas.longitud')
        ->get();

        //dd($heatmapData);

    // Consultar listas de zonas y localidades
    $zonas = DB::table('zona')->pluck('nombre', 'id');
    $localidades = DB::table('localidad')->pluck('nombre', 'id');

    // Pasar los datos y filtros a la vista
    return view('mapaCalor', [
        'heatmapData' => $heatmapData,
        'zonas' => $zonas,
        'localidades' => $localidades,
    ]);

    }


    public function filtrar(Request $request){

        $zona = $request->input('zona');
        $localidad = $request->input('localidad');
        $horaMinima = $request->input('hora_minima');
        $horaMaxima = $request->input('hora_maxima');
    
        // Construir la consulta base
        $query = DB::table('coordenadas_geograficas')
        ->select(
            'coordenadas_geograficas.latitud as lat',
            'coordenadas_geograficas.longitud as lng',
            DB::raw('COUNT(registro_de_delitos.id) as count')
        )
        ->join('zona', 'coordenadas_geograficas.fk_zona', '=', $zona = floatval($zona)) // Relación entre coordenadas_geograficas y zona
        ->join('localidad', 'zona.fk_localidad', '=', $localidad=floatval($localidad)) // Relación entre zona y localidad
        ->join('registro_de_delitos', 'registro_de_delitos.fk_ubicacion', '=', $localidad=floatval($localidad)) // Relación entre registro_de_delitos y localidad
        ->when($zona, function ($query, $zona) { // Filtro dinámico para zona
            return $query->where('zona.id', $zona);
        })
        ->when($localidad, function ($query, $localidad) { // Filtro dinámico para localidad
            return $query->where('localidad.id', $localidad=floatval($localidad));
        })
        ->groupBy('coordenadas_geograficas.latitud', 'coordenadas_geograficas.longitud')
        ->get();
    dd($query);
           // dd($query->toSql());

           if ($zona) {
            $query->where('zona.nombre', $zona);
        }
        if ($localidad) {
            $query->where('localidad.nombre', $localidad);
        }
        if ($horaMinima && $horaMaxima) {
            $query->whereBetween('registro_de_delitos.hora', [$horaMinima, $horaMaxima]);
        }
    
        // Ejecutar la consulta y obtener los datos filtrados
        $heatmapData = $query->get();
    
        // Consultar listas de zonas y localidades para el formulario
        $zonas = DB::table('zona')->pluck('nombre', 'id');
        $localidades = DB::table('localidad')->pluck('nombre', 'id');
    
        // Pasar los datos y filtros a la vista
        return view('mapaCalor', [
            'heatmapData' => $heatmapData,
            'zonas' => $zonas,
            'localidades' => $localidades,
        ]);
    }
}
