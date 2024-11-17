// Capturar filtros
$zona = $request->input('zona');
$localidad = $request->input('localidad');
$horaMinima = $request->input('hora_minima');
$horaMaxima = $request->input('hora_maxima');

// Consulta para agrupar delitos por coordenadas
$query= DB::table('registro_de_delitos')
    ->join('localidad', 'registro_de_delitos.fk_ubicacion', '=', 'localidad.id')
    ->join('zona', 'localidad.fk_zona', '=', 'zona.id')
    ->join('coordenadas_geograficas', 'zona.fk_coordenadasGeograficas', '=', 'coordenadas_geograficas.id')
    ->select(
        'coordenadas_geograficas.latitud as lat',
        'coordenadas_geograficas.longitud as lng',
        DB::raw('COUNT(registro_de_delitos.id) as count')
    )
    ->groupBy('coordenadas_geograficas.latitud', 'coordenadas_geograficas.longitud')
    ->get();


     // Aplicar filtros dinámicos
if ($zona) {
    $query->where('zona.nombre', $zona);
}
if ($localidad) {
    $query->where('localidad.nombre', $localidad);
}
if ($horaMinima && $horaMaxima) {
    $query->whereBetween('registro_de_delitos.hora', [$horaMinima, $horaMaxima]);
}

// Agrupar y ejecutar la consulta
$data = $query
    ->groupBy('coordenadas_geograficas.latitud', 'coordenadas_geograficas.longitud')
    ->get();

// Pasar los datos y filtros a la vista
$zonas = DB::table('zona')->pluck('nombre');
$localidades = DB::table('localidad')->pluck('nombre');
return view('heatmap', [
    'heatmapData' => $data,
    'zonas' => $zonas,
    'localidades' => $localidades,
]);

// Pasar los datos a la vista
// return view('mapaCalor', ['heatmapData' => $data]);



VISTA FORMULARIO

<form method="GET" action="{{ route('heatmap') }}">
    <label for="zona">Zona:</label>
    <select name="zona" id="zona">
        <option value="">Selecciona una zona</option>
       @foreach ($zonas as $id => $nombre)
            <option value="{{ $id }}">{{ $nombre }}</option> 
        @endforeach
    </select>

    <label for="localidad">Localidad:</label>
    <select name="localidad" id="localidad">
        <option value="">Selecciona una localidad</option>
        @foreach ($localidades as $id => $nombre)
            <option value="{{ $id }}">{{ $nombre }}</option> <!-- Cambié el valor a $id -->
        @endforeach
    </select>

    <label for="hora_minima">Hora mínima:</label>
    <input type="time" name="hora_minima" id="hora_minima">

    <label for="hora_maxima">Hora máxima:</label>
    <input type="time" name="hora_maxima" id="hora_maxima">

    <button type="submit">Filtrar</button>
</form>