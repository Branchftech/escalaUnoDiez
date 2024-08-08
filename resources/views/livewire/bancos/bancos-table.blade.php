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
                        <button class="btn btn-primary" wire:click="$emit('openEditModal', {{ $item->id }})">
                            Editar
                        </button>
                        <!-- Botón para abrir modal de eliminar -->
                        <button class="btn btn-danger" wire:click="$emit('openDeleteModal', {{ $item->id }})">
                            Eliminar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Componentes modales para editar y eliminar -->
    <livewire:bancos.editar-banco  />
    <livewire:bancos.eliminar-banco  />
</div>

