<?php

namespace App\Http\Controllers\Egresos;

use App\Http\Controllers\Controller;
use App\Models\Egreso;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class EgresosController extends Controller
{
    public function index()
    {
        return view('main-page.egresos.EgresosMain');
    }

    public static function pdfRecibo($id)
    {
        $egreso = Egreso::find($id);

        // Verificar si el egreso existe
        if (!$egreso) {
            return redirect()->back()->with('error', 'Egreso no encontrado');
        }
        // Llamar al método estático numero_a_letras
        $cantidadLetra = self::numero_a_letras($egreso->cantidad);
        // Pasar los datos de la cantidad en letras al objeto $egreso
        $egreso->cantidad_letras = $cantidadLetra;
        // Si el egreso no está firmado, redirigir al formulario de firma
        if ($egreso->firmado == 0) {
            return view('pdf.recibo.firmarRecibo', compact('egreso'));
        }

        // Obtener la firma guardada, si existe
        $firmaPath = 'firmas/firma_' . $egreso->id . '.png';

        if (Storage::disk('public')->exists($firmaPath)) {
            //$firmaUrl = asset('storage/' . $firmaPath);
            $firmaUrl = storage_path('app/public/' . $firmaPath);

        } else {
            $firmaUrl = null; // Firma no encontrada
        }

        // Generar el PDF con la firma en la parte inferior derecha
        $pdf = PDF::loadView('pdf.recibo.recibo', compact('egreso', 'firmaUrl'));

        // Definir el nombre del archivo PDF
        $fileName = 'recibo_' . $egreso->id . '.pdf';
        $filePath = 'pdfs/' . $fileName;

        // // Guardar el PDF en storage si no existe
        // if (!Storage::disk('public')->exists($filePath)) {
        //     Storage::disk('public')->put($filePath, $pdf->output());
        // }

        // Mostrar el PDF generado
        return $pdf->stream('pdfRecibo.pdf');
    }

    public function mostrarFormularioFirma($id)
    {
        $egreso = Egreso::find($id);

        if (!$egreso) {
            return redirect()->back()->with('error', 'Egreso no encontrado');
        }
        // Llamar al método estático numero_a_letras
        $cantidadLetra = self::numero_a_letras($egreso->cantidad);
        // Pasar los datos de la cantidad en letras al objeto $egreso
        $egreso->cantidad_letras = $cantidadLetra;
        // Mostrar el formulario de firma
        return view('pdf.recibo.firmarRecibo', compact('egreso'));
    }

    public function guardarFirma(Request $request)
    {
        // Decodificar la imagen base64
        $data = $request->input('firma');
        $data = str_replace('data:image/png;base64,', '', $data);
        $data = str_replace(' ', '+', $data);
        $imageData = base64_decode($data);

        // Crear una imagen y guardarla en storage
        $fileName = 'firma_' . $request->egreso_id . '.png';
        Storage::disk('public')->put('firmas/' . $fileName, $imageData);

        // Actualizar el estado del egreso como firmado
        $egreso = Egreso::find($request->egreso_id);
        if ($egreso) {
            $egreso->firmado = 1;
            $egreso->save();

            // Devolver una respuesta JSON de éxito
            return response()->json(['success' => true]);
        }

        // Devolver una respuesta JSON de error si el egreso no se encontró
        return response()->json(['success' => false, 'message' => 'Egreso no encontrado'], 404);
    }

    // Método estático para convertir números a letras
    public static function numero_a_letras($numero)
    {
        $formatter = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
        $entero = floor($numero); // Parte entera
        $centavos = round(($numero - $entero) * 100); // Parte decimal

        $texto = $formatter->format($entero);

        if ($centavos > 0) {
            return ucfirst($texto) . ' pesos con ' . $centavos . '/100';
        } else {
            return ucfirst($texto) . ' ';
        }
    }

    public function generarReporte(Request $request)
    {
        // Obtén los valores seleccionados
        $obraId = $request->input('obra_id');
        $proveedorId = $request->input('proveedor_id');
        $servicioId = $request->input('servicio_id');

        // Consulta para obtener los egresos filtrados
        $egresos = Egreso::where('idObra', $obraId)
                        ->where('idProveedor', $proveedorId)
                        ->whereHas('servicios', function($query) use ($servicioId) {
                            $query->where('servicio.id', $servicioId);
                        })
                        ->get();

        // Generar el PDF, pasando los egresos y un mensaje en caso de no haber resultados
        //$pdf = PDF::loadView('pdf.recibo.reporteEgreso', );

        // Descargar el PDF
        // return view('pdf.recibo.reporteEgreso', [
        //     'egresos' => $egresos,
        //     'mensaje' => $egresos->isEmpty() ? 'No se encontraron egresos para los criterios seleccionados.' : null,
            // ]);
        // Generar el PDF con la firma en la parte inferior derecha
        $pdf = PDF::loadView('pdf.recibo.reporteEgreso',[
                'egresos' => $egresos,
                'mensaje' => $egresos->isEmpty() ? 'No se encontraron egresos para los criterios seleccionados.' : null,
                ]);
        // Mostrar el PDF generado
        return $pdf->stream('reporteEgreso.pdf');

    }
}
