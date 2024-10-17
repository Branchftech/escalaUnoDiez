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
            overflow: hidden;
            padding-bottom: 10px;
            font-weight: bold;
        }
        .logo {
            float: left;
            width: 200px;
            height: 130px;
        }
        .title {
            display: inline-block;
            font-size: 50px;
            font-weight: bold;
            color: blue;
            line-height: 130px;
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
        }
        #signatureCanvas {
            border: 1px solid black;
            width: 200px;
            height: 100px;
            margin-left: auto;
        }
        #saveSignature, #clearSignature {
            margin-top: 10px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/logo.png') }}" alt="Logo" class="logo">
            <span class="title">RECIBO</span>
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
            <p>Por favor, firme dentro del recuadro:</p>

            <canvas id="signatureCanvas"></canvas>
            <br>
            <button id="clearSignature">Limpiar</button>
            <button id="saveSignature">Guardar Firma</button>
        </div>

    </div>

    <script>
        var canvas = document.getElementById('signatureCanvas');
        var ctx = canvas.getContext('2d');
        var drawing = false;
        var isSaved = false;  // Variable para controlar si la firma ha sido guardada
        var isEmpty = true;   // Variable para controlar si el canvas está vacío

        // Comenzar a dibujar
        canvas.addEventListener('mousedown', function(e) {
            if (!isSaved) {
                drawing = true;
                ctx.moveTo(e.offsetX, e.offsetY);
                isEmpty = false;  // Marcamos que el canvas ya no está vacío
            }
        });

        // Continuar dibujando
        canvas.addEventListener('mousemove', function(e) {
            if (drawing && !isSaved) {
                ctx.lineTo(e.offsetX, e.offsetY);
                ctx.stroke();
            }
        });

        // Detener el dibujo
        canvas.addEventListener('mouseup', function() {
            drawing = false;
        });

        // Limpiar el canvas
        document.getElementById('clearSignature').addEventListener('click', function() {
            if (!isSaved) {
                ctx.clearRect(0, 0, canvas.width, canvas.height); // Limpia el contenido del canvas
                ctx.beginPath(); // Restablece el contexto del canvas para evitar trazos antiguos
                isEmpty = true;  // Marcamos que el canvas está vacío
            }
        });

        // Guardar la firma
        document.getElementById('saveSignature').addEventListener('click', function() {
            if (isEmpty) {
                alert('No puede guardar una firma vacía.');
                return;
            }

            if (!isSaved) {
                var confirmation = confirm('¿Está seguro de que desea guardar la firma? No podrá editarla después.');
                if (confirmation) {
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
                            isSaved = true;
                            document.getElementById('saveSignature').disabled = true;  // Deshabilitar el botón de guardar
                            document.getElementById('clearSignature').disabled = true; // Deshabilitar el botón de limpiar
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            }
        });

        // Función para verificar si el canvas está vacío
        function isCanvasEmpty(canvas) {
            const blank = document.createElement('canvas');
            blank.width = canvas.width;
            blank.height = canvas.height;
            return canvas.toDataURL() === blank.toDataURL();
        }
    </script>

</body>
</html>

