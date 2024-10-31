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
    protected $listeners = ['reverseGeocode' => 'reverseGeocode', 'recargarMapa' => 'recargarMapa', 'refreshMapa' => 'refreshMapa'];

    public function mount($id)
    {
        $this->id = $id;
        $this->model = Obra::with(['detalle' => function ($query) {
            $query->whereNull('deleted_at');
        }])->find($id);

        // Si no se encuentra la obra, redirigir a la página de error 404
        if (!$this->model) {
            abort(404); // Redirige a la vista de error 404
        }

        if ($this->model->detalle->direccion) {
            $this->calle = $this->model->detalle->direccion->calle ?? null;
            $this->manzana = $this->model->detalle->direccion->manzana ?? null;
            $this->lote = $this->model->detalle->direccion->lote ?? null;
            $this->pais = $this->model->detalle->direccion->pais->nombre ?? null;
            $this->estado = $this->model->detalle->direccion->estado->nombre ?? null;
            $this->lat = $this->model->detalle->direccion->latitud ?? null;
            $this->lng = $this->model->detalle->direccion->longitud ?? null;

        }
        // Inicializa la geocodificación para obtener las coordenadas solo si no se han guardado previamente
        if (!$this->lat || !$this->lng) {

            $this->geocodeAddress();
        }
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
        $client = new Client();

        try {

            $response = $client->get('https://nominatim.openstreetmap.org/reverse', [
                'query' => [
                    'lat' => $lat,
                    'lon' => $lng,
                    'format' => 'json'
                ],
                'headers' => [
                    'User-Agent' => 'YourAppName/1.0 (eunodiez@gmail.com)'
                ]
            ]);

            $responseData = json_decode($response->getBody(), true);

            if (!empty($responseData)) {
                $this->calle = $responseData['address']['road'] ?? '';
                $this->estado = $responseData['address']['state'] ?? $responseData['address']['city'] ?? '';
                $this->pais = $responseData['address']['country'] ?? '';
            }

            $this->lat = $lat;
            $this->lng = $lng;

            $this->dispatch('refreshDireccion', $this->calle, $this->estado, $this->pais, $this->lat, $this->lng);
            //$this->refreshMapa($this->lat, $this->lng);
            // $this->render();
        } catch (\Exception $e) {
            $this->calle = null;
            $this->estado = null;
            $this->pais = null;
            $this->lat = null;
            $this->lng = null;
        }
    }

    public function refreshMapa($latitud, $longitud)
    {
        $this->lat = $latitud;
        $this->lng = $longitud;

        $coordenadas = [
            'latitud' => $this->lat,
            'longitud' => $this->lng,
        ];

        $this->dispatch('updateMap', compact('coordenadas'));  // Actualiza el mapa con las nuevas coordenadas
    }
}

