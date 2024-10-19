<?php

namespace App\Livewire\DetallesObras;

use Livewire\Component;
use App\Models\DetalleObra;
use App\Models\Obra;
use GuzzleHttp\Client;
use App\Livewire\DetallesObras;

class DetallesObrasTable extends Component
{
    public $model;
    public $calle,$id, $manzana, $lote, $estado,$pais, $fraccionamiento, $lat, $lng;
    protected $listeners = ['reverseGeocode' => 'reverseGeocode', 'recargarMapa' => 'recargarMapa','refreshDetallesObrasTable' => '$refresh'];

    public function mount($id)
    {
        $this->id = $id;
        $this->model = Obra::with('detalle')->find($id);

        if ($this->model->direccion) {
            $this->calle = $this->model->direccion->calle ?? null;
            $this->manzana = $this->model->detalle->direccion->manzana ?? null;
            $this->lote = $this->model->detalle->direccion->lote ?? null;
            $this->pais = $this->model->detalle->direccion->pais->nombre ?? null;
            $this->estado = $this->model->detalle->direccion->estado->nombre ?? null;
        }
        // Inicializa la geocodificación para obtener las coordenadas
        $this->geocodeAddress();
    }

    public function recargarMapa($id)
    {
        $this->id = $id;
        $this->model = Obra::with('detalle')->find($id);

        $this->calle = $this->model->detalle->direccion->calle ?? null;
        $this->manzana = $this->model->detalle->direccion->manzana ?? null;
        $this->lote = $this->model->detalle->direccion->lote ?? null;
        $this->pais = $this->model->detalle->direccion->pais->nombre ?? null;
        $this->estado = $this->model->detalle->direccion->estado->nombre ?? null;

        $this->geocodeAddress();
    }


    public function geocodeAddress()
    {
        $this->model = Obra::with('detalle')->find($this->model->id);
        $this->calle = $this->model->detalle->direccion->calle ?? null;
        $this->pais = $this->model->detalle->direccion->pais->nombre ?? "Mexico";
        $this->estado = $this->model->detalle->direccion->estado->nombre ?? "Ciudad de Mexico";

        $direccion = "$this->calle, $this->estado, $this->pais";

        $client = new Client();

        try {
            $response = $client->get('https://nominatim.openstreetmap.org/search', [
                'query' => [
                    'q' => $direccion,
                    'format' => 'json',
                    'limit' => 1
                ],
                'headers' => [
                    'User-Agent' => 'YourAppName/1.0 (eunodiez@gmail.com)' // Reemplaza con tu correo y nombre de app
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);

            if (!empty($responseData)) {
                $this->lat = $responseData[0]['lat'];
                $this->lng = $responseData[0]['lon'];
            } else {
                $this->lat = 19.42305;
                $this->lng = -99.13376;
            }

        } catch (\Exception $e) {
            $this->lat = 19.42305;
            $this->lng = -99.13376;
        }
        $coordenadas = [
            'latitud' => $this->lat,
            'longitud' => $this->lng,
        ];
        $this->dispatch('updateMap', compact('coordenadas'));
    }

    public function reverseGeocode($lat, $lng)
    {
       // $this->dispatch('recargar');

        $client = new Client();

        try {

            $response = $client->get('https://nominatim.openstreetmap.org/reverse', [
                'query' => [
                    'lat' => $lat,
                    'lon' => $lng,
                    'format' => 'json'
                ],
                'headers' => [
                    'User-Agent' => 'YourAppName/1.0 (eunodiez@gmail.com)' // Reemplaza con tu correo y nombre de app
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);

            if (!empty($responseData)) {

                $this->calle = $responseData['address']['road'] ?? '';
                $this->estado = isset($responseData['address']['state']) ? $responseData['address']['state'] : (isset($responseData['address']['city']) ? $responseData['address']['city'] : '');
                $this->pais = $responseData['address']['country'] ?? '';

               // $this->dispatch('refreshDireccion', $this->calle, $this->estado, $this->pais)->to(EditarDetalleObra::class);
               //$this->emitTo('App\\Livewire\\DetallesObras\\EditarDetalleObra', 'refreshDireccion', $this->calle, $this->estado, $this->pais);

            } else {
                $this->calle = null;
                $this->estado = null;
                $this->pais = null;
            }
        } catch (\Exception $e) {
            $this->calle = null;
            $this->estado = null;
            $this->pais = null;
        }
        // Actualiza las coordenadas
        $this->lat = $lat;
        $this->lng = $lng;
        $coordenadas = [
            'latitud' => $this->lat,
            'longitud' => $this->lng,
        ];
        $this->dispatch('updateMap', compact('coordenadas'));
        $this->dispatch( 'refreshDireccion', $this->calle, $this->estado, $this->pais);
        //$this->dispatch('refreshDetallesObrasTable');

    }




}

