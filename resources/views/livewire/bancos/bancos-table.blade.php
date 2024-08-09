<div>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Creado por</th>
                <th>Fecha de Creación</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($bancos as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->nombre }}</td>
                    <td>{{ $item->created_by }}</td>
                    <td>{{ $item->created_at->format('d/m/Y') }}</td>
                    <td>
                         <!-- Botón para abrir modal de editar -->
                         <x-button class="btn btn-primary" x-data x-on:click="$dispatch('open-modal', {name: 'Editar-Banco'})">
                            Editar
                        </x-button>
                        <!-- Botón para abrir modal de eliminar -->
                        <x-button class="btn btn-danger" x-data x-on:click="$dispatch('open-modal', {name: 'Eliminar-Banco'})">
                            Eliminar
                        </x-button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

