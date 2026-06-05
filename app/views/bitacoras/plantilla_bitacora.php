<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Bitácora - <?= $bitacora['nombreArea'] ?></title>
    <style>
        /* Reseteo básico para que el PDF salga limpio */
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #374151; font-size: 14px; margin: 0; padding: 0; }

        /* HEADER */
        .header { width: 100%; border-bottom: 3px solid #2CA1C8; padding-bottom: 15px; margin-bottom: 30px; }
        .header table { width: 100%; }
        .header td { vertical-align: middle; }
        .logo-text { font-size: 24px; font-weight: bold; color: #2CA1C8; letter-spacing: -0.5px; }
        .system-name { font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; }
        .date-print { text-align: right; font-size: 12px; color: #9ca3af; }

        /* TÍTULO PRINCIPAL */
        .titulo { text-align: center; color: #1f2937; margin-bottom: 30px; font-size: 20px; text-transform: uppercase; letter-spacing: 1px; }

        /* TABLA DE INFORMACIÓN GENERAL */
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 35px; }
        .info-table th { background-color: #f9fafb; color: #6b7280; text-align: left; padding: 12px; font-size: 12px; text-transform: uppercase; border: 1px solid #e5e7eb; width: 30%; }
        .info-table td { padding: 12px; border: 1px solid #e5e7eb; font-weight: bold; color: #111827; font-size: 14px; }

        /* LOS CUADRITOS DE RESUMEN (Usamos una tabla para que Dompdf no lo rompa) */
        .stats-table { width: 100%; text-align: center; margin-bottom: 40px; border-spacing: 15px; border-collapse: separate; }
        .stat-box { padding: 20px 10px; border-radius: 8px; width: 33.33%; }
        .box-total { background-color: #f3f4f6; border: 1px solid #d1d5db; }
        .box-con { background-color: #e0f8ff; border: 1px solid #bce6f4; } /* Fondo cyan clarito */

        .stat-title { font-size: 11px; text-transform: uppercase; font-weight: bold; margin-bottom: 8px; }
        .stat-number { font-size: 32px; font-weight: bold; }

        /* Colores específicos de los números */
        .text-total { color: #4b5563; }
        .text-cyan { color: #2CA1C8; }

        /* OBSERVACIONES */
        .observaciones-box { background-color: #f9fafb; border-left: 5px solid #2CA1C8; padding: 20px; margin-bottom: 30px; }
        .obs-title { font-weight: bold; color: #2CA1C8; font-size: 13px; text-transform: uppercase; margin-bottom: 10px; }
        .obs-content { color: #4b5563; line-height: 1.6; font-size: 13px; font-style: italic; }

        /* FIRMAS */
        .firmas-table { width: 100%; margin-top: 60px; text-align: center; }
        .firma-linea { width: 200px; border-top: 1px solid #9ca3af; margin: 0 auto 10px auto; }
        .firma-texto { font-size: 12px; color: #6b7280; text-transform: uppercase; }

        /* FOOTER DE PÁGINA */
        .footer { position: fixed; bottom: -10px; left: 0; right: 0; width: 100%; text-align: center; font-size: 10px; color: #9ca3af; border-top: 1px solid #e5e7eb; padding-top: 10px; }
    </style>
</head>
<body>

<div class="header">
    <table>
        <tr>
            <td>
                <div class="logo-text">LicenciasPro</div>
                <div class="system-name">Sistema de Gestión de Licencias</div>
            </td>
            <td class="date-print">
                Impreso el: <?= date('d/m/Y') ?><br>
                Hora: <?= date('h:i A') ?>
            </td>
        </tr>
    </table>
</div>

<h1 class="titulo">Reporte de Auditoría y Bitácora</h1>

<table class="info-table">
    <tr>
        <th>Área Inspeccionada</th>
        <td><?= htmlspecialchars($bitacora['nombreArea']) ?></td>
    </tr>
    <tr>
        <th>Técnico Responsable</th>
        <td><?= htmlspecialchars($bitacora['usuario']) ?></td>
    </tr>
    <tr>
        <th>Fecha de Revisión</th>
        <td><?= date('d/m/Y \a \l\a\s h:i A', strtotime($bitacora['fechaRevision'])) ?></td>
    </tr>
</table>

<table class="stats-table">
    <tr>
        <td class="stat-box box-total">
            <div class="stat-title text-total">Total Equipos</div>
            <div class="stat-number text-total"><?= $bitacora['totalEquipos'] ?></div>
        </td>
        <td class="stat-box box-con">
            <div class="stat-title text-cyan">Con Licencia</div>
            <div class="stat-number text-cyan"><?= $bitacora['equiposConLicencia'] ?></div>
        </td>
        <td class="stat-box box-con">
            <div class="stat-title text-cyan">Sin Licencia</div>
            <div class="stat-number text-cyan"><?= $bitacora['equiposSinLicencia'] ?></div>
        </td>
    </tr>
</table>

<div class="observaciones-box">
    <div class="obs-title">Observaciones del Técnico:</div>
    <div class="obs-content">
        <?php
        // nl2br convierte los saltos de línea del textarea en <br> para el PDF
        // y usamos null coalescing '??' por si la dejaron vacía
        $obs = trim($bitacora['observaciones'] ?? '');
        echo !empty($obs) ? nl2br(htmlspecialchars($obs)) : "Ninguna observación registrada durante la auditoría.";
        ?>
    </div>
</div>

<table class="firmas-table">
    <tr>
        <td>
            <div class="firma-linea"></div>
            <div class="firma-texto">Firma del Técnico</div>
            <div style="font-size: 11px; color: #111827; font-weight: bold; margin-top: 5px;">
                <?= htmlspecialchars($bitacora['usuario']) ?>
            </div>
        </td>
        <td>
            <div class="firma-linea"></div>
            <div class="firma-texto">Firma Jefe de Área</div>
        </td>
    </tr>
</table>

<div class="footer">
    Generado automáticamente por LicenciasPro
</div>

</body>
</html>