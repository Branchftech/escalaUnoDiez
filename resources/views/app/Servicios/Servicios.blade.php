<x-app-layout>

    <!-- Contenido de tu página aquí -->
    <div style="margin: 20px; padding: 20px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <div style="margin: 0 auto;">

                <div class='card-title'>
                    <h3>Crear banco</h3>

                </div>
                <div class='card-body' id="busqueda">
                    <div class="row  datos" >
                        <div class='col-md-1'>
                            <label class='col-form-label '>Nombre</label>
                        </div>
                        <div class="col-md-2">
                            <input id='nroBoleta' name='nroBoleta' type='number' class='form-control'placeholder="nombre" >
                        </div>

                    </div>
                    <div class='row p-1 botones'>
                        <div >
                            <button id='limpiar' class='btn btn-secondary' style="width:75%">Limpiar</button>
                        </div>
                        <div >
                            <button id='buscarBoleta' type='button' onclick="buscarBoleta()" class='btn btn-primary'style="width:75%">Buscar</button>
                        </div>
                    </div>
                </div>

        </div>
    </div>
</x-app-layout>
