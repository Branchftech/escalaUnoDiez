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
            <div class="tab-pane fade" id="ex-with-icons-tabs-3" role="tabpanel" aria-labelledby="ex-with-icons-tab-3">
                <div style="margin:2rem">
                    <div id="map" style="height: 400px; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

</div>
@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
       document.addEventListener('DOMContentLoaded', function() {
           let mapInitialized = false;

           // Escucha el evento de cambio de pestaña
           document.querySelector('a[href="#ex-with-icons-tabs-3"]').addEventListener('shown.bs.tab', function () {
               if (!mapInitialized) { // Inicializa el mapa solo si no ha sido inicializado
                   const lat = @json($lat);
                   const lng = @json($lng);

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

                   var map = L.map('map').setView([latitude, longitude], 13);

                   L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                       maxZoom: 19,
                       attribution: '© OpenStreetMap'
                   }).addTo(map);

                   var marker = L.marker([latitude, longitude]).addTo(map);

                   // Forzar redimensionamiento
                   map.invalidateSize();

                   mapInitialized = true; // Marca el mapa como inicializado
               }
           });
       });
    </script>
@endpush

