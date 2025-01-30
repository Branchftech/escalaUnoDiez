<x-app-layout>
    <x-slot name="header">
            {{ __('Regiones') }}
    </x-slot>

    <div class="container mt-4">
        <div class="accordion" id="accordionUbicaciones">
        <!-- Acordeón de Países -->
            <div wire:key='paises'>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingPaises">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePaises" aria-expanded="false" aria-controls="collapsePaises">
                            Países
                        </button>
                    </h2>
                    <div id="collapsePaises" class="accordion-collapse collapse" aria-labelledby="headingPaises" data-bs-parent="#accordionUbicaciones">
                        <div class="accordion-body">
                            <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
                                    <h4>Lista de Países</h4>
                                    <livewire:paises.crear-pais />
                                </div>
                                <livewire:paises.paises-table />
                            </div>
                            <livewire:paises.editar-pais  />
                            <livewire:paises.eliminar-pais  />
                        </div>
                    </div>
                </div>
            </div>
            <!-- Acordeón de Estados -->
            <div wire:key='estados'>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingEstados">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseEstados" aria-expanded="false" aria-controls="collapseEstados">
                            Estados
                        </button>
                    </h2>
                    <div id="collapseEstados" class="accordion-collapse collapse" aria-labelledby="headingEstados" data-bs-parent="#accordionUbicaciones">
                        <div class="accordion-body">
                            <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
                                    <h4>Lista de Estados</h4>
                                    <livewire:estados.crear-estado />
                                </div>
                                <livewire:estados.estados-table />
                            </div>
                            <livewire:estados.editar-estado  />
                            <livewire:estados.eliminar-estado  />

                        </div>
                    </div>
                </div>
            </div>
            <!-- Acordeón de Ciudades -->
            <div wire:key='ciudades'>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingCiudades">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCiudades" aria-expanded="false" aria-controls="collapseCiudades">
                            Ciudades
                        </button>
                    </h2>
                    <div id="collapseCiudades" class="accordion-collapse collapse" aria-labelledby="headingCiudades" data-bs-parent="#accordionUbicaciones">
                        <div class="accordion-body">
                            <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
                                <div style="display: flex; justify-content: space-between; align-items: center;" class="pb-5">
                                    <h4>Lista de Ciudades</h4>
                                    <livewire:ciudades.crear-ciudad />
                                </div>
                                <livewire:ciudades.ciudades-table />
                            </div>
                            <livewire:ciudades.editar-ciudad  />
                            <livewire:ciudades.eliminar-ciudad  />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 debe estar incluido en el proyecto para que funcione el acordeón -->



</x-app-layout>
