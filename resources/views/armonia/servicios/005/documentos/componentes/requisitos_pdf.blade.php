<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 916px;
            margin: 0 auto;
            font-size: 13px;
            overflow: hidden;
        }

        .header {
            margin-bottom: 20px;
        }

        .header img {
            float: left;
            width: 150px;
            margin-right: 20px;
        }

        .header .header-text {
            flex: 1;
            text-align: right;
            line-height: 1;
        }

        .header h1 {
            color: black;
            font-size: 18px;
            margin: 0;
        }

        .header_tabla {
            margin-top: 50px;
        }

        .header_tabla h1 {
            color: black;
            font-size: 15px;
            margin: 0;
        }

        .header::after {
            content: "";
            display: table;
            clear: both;
        }

        .content {
            margin-top: 20px;
            text-align: right;
            line-height: 1.2;
        }

        .content p {
            margin: 5px 0;
        }

        .justified {
            text-align: justify;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-weight: bold;
        }

        .highlight {
            color: black;
        }

        .line {
            border-top: 3px solid #008000;
            margin: 0px 0;
        }

        .tabla-propuesta {
            width: 100%;
            margin-top: 10px;
        }

        .tabla-propuesta th,
        .tabla-propuesta td {
            border: 1px solid #999;
            padding: 4px;
            text-align: center;
        }

        .tabla-propuesta th {
            background-color: #c5c3c3;
            font-weight: bold;
        }

        .tabla-propuesta .concepto {
            text-align: left;
        }

        .alcance {
            background-color: green;
            color: white;
            padding: 10px;
            text-align: center;
            font-size: 13px;
        }

        .alcance p {
            margin: 0;
        }

        .terms {
            padding-top: 5px;
        }

        .terms p {
            color: black;
            font-size: 13px;
            margin: 10px;
            line-height: 2;
        }

        .firm {
            text-align: center;
        }

        .page-break {
            page-break-before: always;
        }

        /* Estilos específicos para impresión */
        @media print {
            .alcance {
                background-color: #0dbd0d !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .tabla-propuesta th {
                background-color: #f2f2f2 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>

<body>
    <div class="container">
     
        <!-- Encabezado en la nueva página -->
        <div class="header">
            <div class="img-logo">
                <img src="{{ public_path('build/images/logoarmonia.png') }}">
            </div>
            <div class="header-text">
                <h1>ARMONÍA Y CONTRASTE AMBIENTAL, S.A. DE C.V. </h1>
                <p class="highlight"><strong>Unidad de Inspección</strong></p>
                <p style="text-align: right;"><strong>Materia:</strong>Estaciones de Servicio</p>
            </div>
        </div>

        <div class="content">
            <p><strong>Acreditación No.</strong> ES-003</p>
            <p><strong>Aprobación No.</strong> UN05-087/20</p>
        </div>
        <div class="line"></div>

        <h2 style="text-align: center; font-weight: bold; text-decoration: underline; font-size: 16px; margin-top: 30px;">
            Requisitos Operación y Mantenimiento Inspección en Sitio</h2>
        <table class="tabla-propuesta">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allDocuments['inspeccion'] as $doc)
                <tr>
                    <td class="concepto">{{ $doc['descripcion'] }}</td>
                    <td>{{ $doc['tipo'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2 style="text-align: center; font-weight: bold; text-decoration: underline; font-size: 16px; margin-top: 30px;">
            Requisitos Operación y Mantenimiento Documentos Expedidos por Terceros</h2>
        <table class="tabla-propuesta">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allDocuments['terceros'] as $doc)
                <tr>
                    <td class="concepto">{{ $doc['descripcion'] }}</td>
                    <td>{{ $doc['tipo'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</body>

</html>