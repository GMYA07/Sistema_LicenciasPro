<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Equipos</title>
    <style>
        /* Estilos compatibles con Dompdf */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #374151;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        /* Encabezado */
        .header-table { width: 100%; border-bottom: 2px solid #2CA1C8; padding-bottom: 10px; margin-bottom: 20px; }
        .header-left { text-align: left; width: 60%; }
        .header-right { text-align: right; width: 40%; }
        .title { color: #0C3B4C; font-size: 20px; font-weight: bold; margin: 0; }
        .subtitle { color: #6b7280; font-size: 12px; margin-top: 5px; }

        /* Títulos de sección */
        .section-title {
            background-color: #2CA1C8;
            color: #ffffff;
            padding: 6px 12px;
            font-weight: bold;
            margin-top: 25px;
            font-size: 14px;
            border-radius: 3px;
        }

        /* Tabla de Información del Equipo */
        .info-table { width: 100%; margin-top: 15px; border-collapse: collapse; }
        .info-table td { padding: 8px 5px; border-bottom: 1px solid #f3f4f6; }
        .info-table .label { font-weight: bold; color: #4b5563; width: 20%; }
        .info-table .value { color: #1f2937; width: 30%; }

        /* Tabla de Licencias */
        .data-table { width: 100%; margin-top: 15px; border-collapse: collapse; text-align: left; }
        .data-table th {
            background-color: #f9fafb;
            color: #6b7280;
            padding: 10px;
            border-bottom: 2px solid #e5e7eb;
            font-size: 11px;
            text-transform: uppercase;
        }
        .data-table td { padding: 10px; border-bottom: 1px solid #e5e7eb; color: #374151; }

        /* Estados (Colores quemados porque a Dompdf le gusta lo simple) */
        .badge-activa { color: #059669; font-weight: bold; }
        .badge-alerta { color: #d97706; font-weight: bold; }

        /* Pie de página */
        .footer { position: fixed; bottom: -20px; width: 100%; text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 10px; }

        .bloque-equipo {
            page-break-inside: avoid;
            margin-bottom: 30px;
            border: 1px solid #e5e7eb;
            padding: 15px;
            border-radius: 8px;
        }

    </style>
</head>
<body>

<table class="header-table">
    <tr>
        <td class="header-left">
            <h1 class="title">Sistema_LicenciasPro</h1>
            <div class="subtitle">Reporte de Auditoría: <?= $infoArea['nombreArea'] ?></div>
        </td>
        <td class="header-right">
            <div style="font-weight: bold;">Total de Equipos: <?= count($equipos) ?></div>
            <div class="subtitle">Generado el: <?= date('d/m/Y h:i A') ?></div>
        </td>
    </tr>
</table>

<?php foreach ($equipos as $equipo): ?>

    <div class="bloque-equipo">
        <div class="section-title">
            Equipo #<?= $equipo['idComputadora'] ?>
            <span style="float: right; font-weight: normal; font-size: 11px; text-transform: uppercase;">
                Estado: <?= $equipo['estadoComputadora'] ?>
            </span>
        </div>

        <table class="info-table">
            <tr>
                <td class="label">Marca / Modelo:</td>
                <td class="value"><?= $equipo['Marca'] ?> / <?= $equipo['Modelo'] ?></td>
                <td class="label">N° Serie:</td>
                <td class="value"><?= $equipo['Serial'] ?></td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
            <tr>
                <th>Software Instalado</th>
                <th>Clave / Código</th>
                <th>Estado</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($equipo['licencias'])): ?>
                <?php foreach ($equipo['licencias'] as $licencia): ?>
                    <tr>
                        <td style="font-weight: bold;"><?= $licencia['nombreTipoLicencia'] ?></td>
                        <td style="font-family: monospace;"><?= $licencia['codigoLicencia'] ?></td>
                        <td class="badge-activa"><?= $licencia['estadoLicencia'] ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" style="text-align: center; color: #9ca3af; font-style: italic;">
                        Este equipo no tiene software vinculado actualmente.
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div> <?php endforeach; ?>

<div class="footer">
    Generado automáticamente por el módulo de gestión de equipos.
</div>

</body>
</html>
