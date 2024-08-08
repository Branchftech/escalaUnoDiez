<x-app-layout>
    <x-slot name="header">
        <h2 class=" font-weight-bold text-dark">
            {{ __('Perfil') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="text-dark d-flex row flex-wrap">
                <div class="col-md-8">

                    <div class="d-flex justify-content-center mb-4">
                        <div >
                            <h4>Información de perfil</h4>
                            <span class="text-md">Actualiza la informacion de tu cuenta aqui.</span>
                        </div>

                    </div>
                    <livewire:auth.profile />
                </div>
                
            </div>
        </div>

    </div>
</x-app-layout>
