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
            width: 230px;
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
        <!-- Encabezado -->
        <div class="header">
            <div class="img-logo">
                <img src="{{ public_path('build/images/logoarmonia.png') }}">
            </div>
            <div class="header-text">
                <h1>ARMONÍA Y CONTRASTE AMBIENTAL, S.A. DE C.V. </h1>
                <p class="highlight"><strong>Unidad de Inspección</strong></p>
                <p style="text-align: right;"><strong>Materia:</strong> Controles Volumétricos de Hidrocarburos y Petrolíferos</p>
                <p>con base en los Anexos 30 y 31 de la Miscelánea Fiscal</p>
                <p>Publicada el 27 de diciembre de 2021 - actualizada el 9 de marzo de 2022</p>
                <p>Publicada el 27 de diciembre de 2022 y actualizada el 12 de enero de 2023</p>
            </div>
        </div>

        <div class="content">
            <p><strong>Acreditación No.</strong> UICV-011</p>
            <p><strong>Actualización técnica</strong> 2024/06/26</p>
        </div>
        <div class="line"></div>
        <div class="footer">
            <p style="font-size: 14px; margin-top: 5px;">San Jacinto Amilpas, Oaxaca, {{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd D [de] MMMM [de] YYYY') }}.</p>
        </div>

        <!-- Tablas de Requisitos -->
        <h2 style="text-align: center; font-weight: bold; text-decoration: underline; font-size: 16px; margin-top: 30px;">
            Requisitos Anexo 30 y 31 Generales</h2>
        <table class="tabla-propuesta">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allDocuments['generales'] as $doc)
                <tr>
                    <td class="concepto">{{ $doc['descripcion'] }}</td>
                    <td>{{ $doc['tipo'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2 style="text-align: center; font-weight: bold; text-decoration: underline; font-size: 16px; margin-top: 30px;">
            Requisitos Anexo 30 y 31 Sistemas de Medición</h2>
        <table class="tabla-propuesta">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allDocuments['medicion'] as $doc)
                <tr>
                    <td class="concepto">{{ $doc['descripcion'] }}</td>
                    <td>{{ $doc['tipo'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <h2 style="text-align: center; font-weight: bold; text-decoration: underline; font-size: 16px; margin-top: 30px;">
            Requisitos Anexo 30 y 31 Sistemas Informáticos</h2>
        <table class="tabla-propuesta">
            <thead>
                <tr>
                    <th>Descripción</th>
                    <th>Tipo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($allDocuments['informatica'] as $doc)
                <tr>
                    <td class="concepto">{{ $doc['descripcion'] }}</td>
                    <td>{{ $doc['tipo'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Aquí es donde comienza una nueva página -->
        <div class="page-break"></div>

        <!-- Encabezado en la nueva página -->
        <div class="header">
            <div class="img-logo">
                <img src="{{ public_path('build/images/logoarmonia.png') }}">
            </div>
            <div class="header-text">
                <h1>ARMONÍA Y CONTRASTE AMBIENTAL, S.A. DE C.V. </h1>
                <p class="highlight"><strong>Unidad de Inspección</strong></p>
                <p style="text-align: right;"><strong>Materia:</strong> Controles Volumétricos de Hidrocarburos y Petrolíferos</p>
                <p>con base en los Anexos 30 y 31 de la Miscelánea Fiscal</p>
                <p>Publicada el 27 de diciembre de 2021 - actualizada el 9 de marzo de 2022</p>
                <p>Publicada el 27 de diciembre de 2022 y actualizada el 12 de enero de 2023</p>
            </div>
        </div>

        <div class="content">
            <p><strong>Acreditación No.</strong> UICV-011</p>
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