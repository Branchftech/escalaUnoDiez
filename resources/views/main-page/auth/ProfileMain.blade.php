<x-app-layout>
    <x-slot name="header">
            {{ __('Perfil') }}
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="flex-wrap text-dark d-flex row">
                <div class="col-md-8">

                    <div class="mb-4 d-flex justify-content-center">
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
