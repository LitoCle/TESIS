@extends('Layouts.landing')

@section('contenido')
<!-- Formulario para aplicar filtros -->
<form method="POST" action="{{ route('filtrar.post') }}">
    @csrf
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
            <option value="{{ $id }}">{{ $nombre }}</option>
        @endforeach
    </select>

    <label for="hora_minima">Hora mínima:</label>
    <input type="time" name="hora_minima" id="hora_minima">

    <label for="hora_maxima">Hora máxima:</label>
    <input type="time" name="hora_maxima" id="hora_maxima">

    <button type="submit">Filtrar</button>
</form>

                       
<div id="map" style="height: 500px; width: 100%"></div> 

@endsection

@section('scripts')

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://unpkg.com/leaflet.heat"></script>

<script>
    // Inicializa el mapa centrado en una ubicación predeterminada
    var map = L.map('map').setView([-32.9637,-60.6789], 13);

       // Agrega el mapa base desde OpenStreetMap
       L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);


 // Datos de calor (proporcionados desde PHP)
 const heatPoints = @json($heatmapData).map(item => [item.lat, item.lng, item.count]);

// Crear capa de calor
const heatLayer = L.heatLayer(heatPoints, {
    radius: 25, // Radio del punto
    blur: 15,   // Desenfoque
    maxZoom: 12,
    gradient: { // Gradiente de colores
        0.2: 'green',
        0.5: 'yellow',
        1.0: 'red'
    }
});

// Añadir la capa al mapa
heatLayer.addTo(map);

</script>

@endsection 

<!--// Aplicar los filtros dinámicos si están presentes
        /*if ($zona) {
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
    
        dd($zona,$localidad,$horaMinima, $horaMaxima, $heatmapData);
        // Para depuración, descomenta este dd si lo necesitas
        // dd($heatmapData, $zonas, $localidades); */ -->