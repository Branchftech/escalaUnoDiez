<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo</title>
    <style>
         body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 600px;
            border: 1px solid black;
            padding: 20px;
            margin: 0 auto;
        }
        .header {
            width: 100%;
            overflow: hidden; /* Asegura que los elementos flotados se contengan dentro del contenedor */
            padding-bottom: 10px;
            font-weight: bold;
        }
        .logo {
            float: left; /* Alinea la imagen a la izquierda */
            width: 200px;
            height: 130px;
        }
        .title {
            display: inline-block;
            font-size: 5px;
            font-weight: bold;
            color: rgb(49, 1, 153)
            line-height: 100px; /* Alinea verticalmente el texto con la imagen */
            text-align: center;
             /* Restamos el ancho del logo y un pequeño margen */
        }
        .details {
            margin-top: 20px;
            font-weight: bold;
        }
        .details p {
            font-size: 18px;
            font-weight: bold;
        }
        .amount {
            color: red;
            font-size: 20px;
            font-weight: bold;
        }
        .signature {
            margin-top: 50px;
            text-align: right;
            font-weight: bold;
        }
        .signature-line {
            border-top: 1px solid black;
            width: 200px;
            margin-left: auto;
            font-weight: bold;
        }
        #signatureCanvas {
            border: 1px solid black;
            width: 200px;
            height: 100px;
            margin-left: auto;
        }
        #saveSignature {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Logo alineado a la izquierda -->
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo">
            <span style="font-size: 50px; font-weight: bold; color: blue; padding-bottom:0; line-height: 130px;">RECIBO</span>
        </div>

        <div class="details">
            <p style="text-align: right">Querétaro, Qro a {{ \Carbon\Carbon::now()->locale('es')->isoFormat('D [de] MMMM [de] YYYY') }}</p>
            <p style="text-align: right">Cantidad: <span class="amount">${{ $egreso->cantidad }}</span></p>
            <p style="text-align: right">Son {{ $egreso->cantidad_letras }} m.n</p>
            <p>A favor de: <span style="color: red;">{{ $egreso->proveedor->nombre }}</span></p>
            <p>Concepto de Pago: {{ $egreso->concepto }}</p>
            <p>Obra: <span style="color: red;">{{ $egreso->obra->detalle->nombreObra }}</span></p>
        </div>

        <!-- Zona de firma con canvas -->
        <div class="signature">
            <p>Por favor, firme abajo:</p>
            <canvas id="signatureCanvas"></canvas>
            <button id="saveSignature">Guardar Firma</button>
        </div>

    </div>
    {{--
    <script>
        var canvas = document.getElementById('signatureCanvas');
        var ctx = canvas.getContext('2d');
        var drawing = false;

        canvas.addEventListener('mousedown', function(e) {
            drawing = true;
            ctx.moveTo(e.offsetX, e.offsetY);
        });

        canvas.addEventListener('mousemove', function(e) {
            if (drawing) {
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.stroke();
            }
        });

        canvas.addEventListener('mouseup', function() {
            drawing = false;
        });

        // Guardar la firma en base64
        document.getElementById('saveSignature').addEventListener('click', function() {
            var signatureData = canvas.toDataURL('image/png');

            // Enviar la firma al backend
            fetch('/guardar-firma', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    firma: signatureData,
                    egreso_id: {{ $egreso->id }}
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Firma guardada con éxito');
                    window.location.href = '/pdf/recibo/' + {{ $egreso->id }};
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script> --}}
    <script>
        var canvas = document.getElementById('signatureCanvas');
        var ctx = canvas.getContext('2d');
        var drawing = false;

        canvas.addEventListener('mousedown', function(e) {
            drawing = true;
            ctx.moveTo(e.offsetX, e.offsetY);
        });

        canvas.addEventListener('mousemove', function(e) {
            if (drawing) {
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.stroke();
            }
        });

        canvas.addEventListener('mouseup', function() {
            drawing = false;
        });

        // Guardar la firma en base64
        document.getElementById('saveSignature').addEventListener('click', function() {
            var signatureData = canvas.toDataURL('image/png');

            // Enviar la firma al backend con fetch
            fetch('/guardar-firma', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' // Asegúrate de que se está enviando el token CSRF
                },
                body: JSON.stringify({
                    firma: signatureData,
                    egreso_id: {{ $egreso->id }}
                })
            })
            .then(response => {
                // Verifica si la respuesta es correcta
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Error en la respuesta del servidor');
                }
            })
            .then(data => {
                // Si la firma se guardó correctamente, mostrar un alert
                if (data.success) {
                    alert('Firma guardada con éxito, por favor regrese a la pestaña anterior.');
                } else {
                    alert('Error al guardar la firma');
                }
            })
            .catch(error => {
                console.error('Error en la solicitud:', error);
                alert('Hubo un problema al guardar la firma');
            });
        });
    </script>

</body>
</html>
