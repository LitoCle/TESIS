@extends('Layouts.landing')

@section('contenido')
    <form action="{{route('formulario.guardar')}}" method="POST" class="fondo-transparente">
 @csrf
    
<!-- Mostrar errores de validación -->
@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

    <label for="delitos"> Selecciona un delito:</label>
    <select id="delitos" name= "delitos">
        @foreach ($delitos as $delito)
        <option value="{{$delito->id}}">{{$delito->nombre}}</option>
        @endforeach
    </select>
            
    <label for="objeto_robado">Selecciona un objeto robado:</label>
    <select id="objeto_robado" name="objeto_robado">
        @foreach($objetos as $objeto)
            <option value="{{ $objeto->id }}">{{ $objeto->nombre }}</option>
        @endforeach
    </select>

     <label for="fecha">Fecha del delito:</label>
     <input type="date" id="fecha" name="fecha" required>

     <label for="hora">Hora del delito:</label>
     <input type="time" id="hora" name="hora" required>

     <label for="ubicacion">Ubicación:</label>
        <div id="map" style="height: 500px; width: 100%"></div> <!-- Contenedor para el mapa -->

        <!-- Campos ocultos para almacenar latitud y longitud seleccionadas -->
        <input type="hidden" id="latitud" name="latitud">
        <input type="hidden" id="longitud" name="longitud">

        <label for="localidad">Localidad:</label>
        <input type="text" id="localidad" name="localidad" required>

        <label for="detalles">Detalles:</label>
        <textarea id="detalles" name="detalles"></textarea>

        <button type="submit">Guardar</button>
    
    </form>
@endsection

@section('scripts')

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    // Inicializa el mapa centrado en una ubicación predeterminada
    var map = L.map('map').setView([-32.9637,-60.6789], 13); // Reemplaza con coordenadas iniciales

    // Agrega el mapa base desde OpenStreetMap
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

    // Marcador que el usuario puede arrastrar
    var marker = L.marker([-32.9637,-60.6789], { draggable: true }).addTo(map);

    // Evento para actualizar campos latitud/longitud cuando el marcador se mueve
    marker.on('dragend', function (e) {
        var position = marker.getLatLng();
        document.getElementById('latitud').value = position.lat;
        document.getElementById('longitud').value = position.lng;
    });

    // Permite al usuario hacer clic en el mapa para colocar el marcador
    map.on('click', function (e) {
        marker.setLatLng(e.latlng);
        document.getElementById('latitud').value = e.latlng.lat;
        document.getElementById('longitud').value = e.latlng.lng;
    });
</script>


@endsection

@section('footer')
   @include('Layouts.partials.menuFooter')
@endsection