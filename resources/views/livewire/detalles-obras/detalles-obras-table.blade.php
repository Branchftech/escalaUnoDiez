<div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
    <div class="card animate__animated animate__bounceInRight" wire:ignore.self style="border: 1px #ddd; background-color: #fff;">
        <ul class="nav nav-tabs" id="ex-with-icons" role="tablist" wire:ignore>
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="ex-with-icons-tab-1" data-bs-toggle="tab" href="#ex-with-icons-tabs-1" role="tab" aria-controls="ex-with-icons-tabs-1" aria-selected="true">
                    <i class="fa-solid fa-list-check fa-fw me-2"></i>Bitacora avances
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="ex-with-icons-tab-2" data-bs-toggle="tab" href="#ex-with-icons-tabs-2" role="tab" aria-controls="ex-with-icons-tabs-2" aria-selected="false">
                    <i class="fa-solid fa-file fa-fw me-2"></i>Archivos adjuntos
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="ex-with-icons-tab-3" data-bs-toggle="tab" href="#ex-with-icons-tabs-3" role="tab" aria-controls="ex-with-icons-tabs-3" aria-selected="false">
                    <i class="fa-solid fa-receipt fa-fw me-2"></i>Croquis
                </a>
            </li>
        </ul>

        <div class="tab-content" id="ex-with-icons-content" style="border-top: 1px solid #ddd; background-color: #fff;">
            <div class="tab-pane fade show active" id="ex-with-icons-tabs-1" role="tabpanel" aria-labelledby="ex-with-icons-tab-1" wire:ignore.self>
                <div style="margin:2rem">
                    <livewire:bitacorasObras.crear-bitacoraObra :id="$id" />
                    <livewire:bitacorasObras.bitacorasObras-table :id="$id"/>
                    <livewire:bitacorasObras.editar-bitacoraObra  />
                    <livewire:bitacorasObras.eliminar-bitacoraObra />
                </div>
            </div>
            <div class="tab-pane fade" id="ex-with-icons-tabs-2" role="tabpanel" aria-labelledby="ex-with-icons-tab-2" wire:ignore.self>
                <div style="margin:2rem">
                    <livewire:documentos-obras.crear-documento-obra :id="$id"/>
                    <livewire:documentos-obras.documentos-obras-table :id="$id"/>
                    <livewire:documentos-obras.eliminar-documento-obra  />
                </div>
            </div>
            <div  wire:ignore>
                <div class="tab-pane fade" id="ex-with-icons-tabs-3" role="tabpanel" aria-labelledby="ex-with-icons-tab-3" >
                    <div style="margin:2rem; justify-content: center">
                        <div id="map" style="height: 400px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #map {
        height: 400px; /* Ajusta la altura y el ancho según sea necesario */
        width: 100%;
    }

</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script type="module">

    function mostrarTab1() {
        // Remover la clase 'active' de todas las pestañas
        document.querySelectorAll('.nav-link').forEach(function (tab) {
            tab.classList.remove('active');
        });

        // Añadir la clase 'active' a la pestaña 1
        document.querySelector('a[href="#ex-with-icons-tabs-1"]').classList.add('active');

        // Remover la clase 'show active' de todos los contenidos de las pestañas
        document.querySelectorAll('.tab-pane').forEach(function (pane) {
            pane.classList.remove('show', 'active');
        });

        // Añadir la clase 'show active' al contenido de la pestaña 1
        document.querySelector('#ex-with-icons-tabs-1').classList.add('show', 'active');
    }
    window.addEventListener('livewire:init', () => {
        let mapInitialized = false;
        let marker;
        let leafletMap;

        // Evento al cambiar a la pestaña del mapa
        document.querySelector('a[href="#ex-with-icons-tabs-3"]').addEventListener('shown.bs.tab', function () {
            if (leafletMap) {
                leafletMap.invalidateSize();  // Forzar redimensionamiento al cambiar de pestaña
            }
        });

        // Inicializar el mapa si no está ya inicializado
        function initializeMap(lat, lng) {
            if (!mapInitialized) {
                if (lat === null || lng === null) {
                    console.error('Las coordenadas son nulas. No se puede inicializar el mapa.');
                    return;
                }

                const latitude = parseFloat(lat);
                const longitude = parseFloat(lng);

                if (isNaN(latitude) || isNaN(longitude)) {
                    console.error('Las coordenadas no son válidas:', lat, lng);
                    return;
                }

                // Inicializa el mapa centrado en las coordenadas obtenidas
                leafletMap = L.map('map').setView([latitude, longitude], 13);

                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                    attribution: '© OpenStreetMap'
                }).addTo(leafletMap);

                // Coloca un marcador en las coordenadas iniciales
                marker = L.marker([latitude, longitude], {
                    draggable: true // Permitir que el marcador sea arrastrable
                }).addTo(leafletMap);

                // Evento de arrastrar el marcador
                marker.on('dragend', function(e) {
                    const newLatLng = marker.getLatLng();
                    const newLat = newLatLng.lat;
                    const newLng = newLatLng.lng;

                    // Dispatch a Livewire con las nuevas coordenadas
                    Livewire.dispatch('reverseGeocode', {
                        lat: newLat,
                        lng: newLng
                    });

                    //  // Forzar redimensionamiento del mapa cuando se muestra
                    // leafletMap.invalidateSize();
                    // mapInitialized = true;

                });
            }
        }

        // Maneja la actualización del mapa cuando se guardan nuevas coordenadas
        Livewire.on('updateMap', (data) => {
            const latitude = data[0].coordenadas.latitud;
            const longitude = data[0].coordenadas.longitud;

            if (mapInitialized && marker) {
                // Mueve el marcador a la nueva posición
                marker.setLatLng([latitude, longitude]).update();
                leafletMap.setView([latitude, longitude], 13);  // Centrar el mapa en las nuevas coordenadas
                leafletMap.invalidateSize();  // Redimensionar el mapa
            }
        });

        // Inicializar el mapa al cargar el componente
        const lat = @json($lat);
        const lng = @json($lng);
        initializeMap(lat, lng);
    });


</script>
@endpush

