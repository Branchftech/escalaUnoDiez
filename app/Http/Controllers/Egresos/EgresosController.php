<?php

namespace App\Http\Controllers\Egresos;

use App\Http\Controllers\Controller;
use App\Models\Egreso;
use Barryvdh\DomPDF\Facade\Pdf;

class EgresosController extends Controller
{
    public function index()
    {
        return view('main-page.egresos.EgresosMain');
    }

//     public static function pdfRecibo()
    //     {

    //        // try {
    //            // $egreso = Egreso::find($id);

    // //, compact('invoice', 'user')
    //             $pdf = PDF::loadView('pdf.recibo.recibo');

    //             return $pdf->stream('pdfRecibo.pdf');
    //         // } catch (Exception $e) {
    //         //     Log::error('Error al generar el PDF de la factura: '.$e->getMessage());

    //         //     return redirect()->route('dashboard');
    //         // }
//     }
    public static function pdfRecibo($id) // Recibe el ID
    {
        // Busca el egreso por el ID
        $egreso = Egreso::find($id);

        // Verifica si el egreso existe
        if (!$egreso) {
            return redirect()->back()->with('error', 'Egreso no encontrado');
        }
        // Llamar al método estático numero_a_letras
        $cantidadLetra = self::numero_a_letras($egreso->cantidad);

        // Pasar los datos de la cantidad en letras al objeto $egreso
        $egreso->cantidad_letras = $cantidadLetra; // Añadir este campo temporalmente

        // Genera el PDF y pasa los datos del egreso a la vista
        $pdf = PDF::loadView('pdf.recibo.recibo', compact('egreso'));

        // Retorna el PDF generado
        return $pdf->stream('pdfRecibo.pdf');
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
}
