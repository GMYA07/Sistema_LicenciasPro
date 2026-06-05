<?php include 'inc/Header.php'; ?>


<?php
// --- PROCESAMIENTO DE DATOS PARA LA GRÁFICA DE PASTEL ---
// Extraemos las columnas individuales del resultado SQL
$estadosLabels = array_column($datosPastel, 'estadoLicencia');
$estadosValores = array_column($datosPastel, 'cantidad');

// --- PROCESAMIENTO DE DATOS PARA LA GRÁFICA DE BARRAS ---
$categoriasLabels = array_column($datosBarras, 'categoriaLicencia');
$categoriasValores = array_column($datosBarras, 'cantidad_licencias');
?>


<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-12">
    <div class="flex items-center gap-4">
        <div class="p-3 bg-[#2CA1C8]/10 rounded-2xl text-[#2CA1C8]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold text-[#0C3B4C]">Gestión de Licencias de equipos</h1>
            <p class="text-sm text-gray-500 font-medium mt-1">Sistema creado para administración de licencias de
                computadoras.</p>
        </div>
    </div>
</div>

<div class="flex-1 overflow-y-auto p-6 flex flex-col gap-6" style="background:#F4F8FA;">

    <div class="grid grid-cols-4 gap-4 w-full">

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider block truncate">Licencias
                    Activas</span>
                <span
                    class="text-[10px] px-1.5 py-0.5 rounded-lg bg-green-50 text-[#2CA1C8] font-medium whitespace-nowrap">En
                    uso</span>
            </div>
            <p class="text-2xl font-semibold" style="color:#1E85A8;"><?= htmlspecialchars($licenciasActivas) ?></p>
            <p class="text-[11px] text-gray-400 mt-1 truncate">Equipos activos</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider block truncate">Equipos</span>
                <span
                    class="text-[10px] px-1.5 py-0.5 rounded-lg bg-blue-50 text-[#2CA1C8] font-medium whitespace-nowrap">Total</span>
            </div>
            <p class="text-2xl font-semibold" style="color:#1E85A8;"><?= htmlspecialchars($totalComputadoras) ?></p>
            <p class="text-[11px] text-gray-400 mt-1 truncate">Infraestructura</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider block truncate">Alertas</span>
                <span
                    class="text-[10px] px-1.5 py-0.5 rounded-lg bg-amber-50 text-[#2CA1C8] font-medium whitespace-nowrap animate-pulse">Atención</span>
            </div>
            <p class="text-2xl font-semibold text-[#2CA1C8]"><?= htmlspecialchars($proximasExpirar) ?></p>
            <p class="text-[11px] text-gray-400 mt-1 truncate">Próximos 30 días</p>
        </div>

        <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-medium text-gray-500 uppercase tracking-wider block truncate">Áreas
                    Físicas</span>
                <span
                    class="text-[10px] px-1.5 py-0.5 rounded-lg bg-purple-50 text-[#2CA1C8] font-medium whitespace-nowrap">Sedes</span>
            </div>
            <p class="text-2xl font-semibold" style="color:#2CA1C8;"><?= htmlspecialchars($totalAreas) ?></p>
            <p class="text-[11px] text-gray-400 mt-1 truncate">Laboratorios</p>
        </div>

    </div>

    <div class="grid grid-cols-12 gap-6 w-full">

        <div
            class="col-span-12 md:col-span-4 bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Estado de Licencias</h3>
                <p class="text-xs text-gray-400 mb-4">Ciclo de vida</p>
            </div>
            <div class="relative w-full h-64 flex justify-center">
                <canvas id="pieChartEstados"></canvas>
            </div>
        </div>

        <div
            class="col-span-12 md:col-span-8 bg-white p-5 rounded-2xl border border-gray-200 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="text-sm font-semibold text-gray-800 mb-1">Distribución de Licencias</h3>
                <p class="text-xs text-gray-400 mb-4">Software por categorías</p>
            </div>
            <div class="relative w-full h-64">
                <canvas id="barChartLicencias"></canvas>
            </div>
        </div>

    </div>

    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden w-full flex flex-col">

        <div class="px-5 py-4 border-b border-gray-200 bg-white">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                <div>
                    <h2 class="text-sm font-semibold text-gray-800">Alertas de Software y Equipos Asignados</h2>
                    <p class="text-xs text-gray-400">Detalle físico e historial de vencimientos próximos</p>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3 w-full lg:w-auto lg:max-w-2xl">
                    <div class="relative w-full lg:w-[28rem]">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <input id="buscarEquipoHome" type="text" placeholder="Buscar área, equipo, licencia o código..."
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 placeholder:text-gray-400 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">
                    </div>

                    <a href="<?= BASE_URL ?>/equipos" class="inline-flex items-center justify-center text-xs font-medium whitespace-nowrap hover:underline px-4 py-2.5 rounded-xl border border-cyan-100 bg-cyan-50" style="color:#2CA1C8;">
                        Ver todos los equipos →
                    </a>
                </div>
            </div>
        </div>

        <div class="overflow-y-auto max-h-[550px] w-full">

            <div class="overflow-x-auto horizontal-scroll-fix">
                <table class="min-w-full divide-y divide-gray-200 align-middle table-fixed shadow-sm">

                    <thead class="sticky top-0 bg-gray-50 z-10">
                        <tr class="bg-gray-50 drop-shadow-[0_1px_0px_rgba(229,231,235,1)]">
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider bg-gray-50">
                                Área / Edificio</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider bg-gray-50">
                                Equipo / Modelo</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider bg-gray-50">
                                Licencia Asignada</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider bg-gray-50">
                                Código de Licencia</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider bg-gray-50">
                                Vencimiento</th>
                        </tr>
                    </thead>

                    <tbody id="tablaEquiposHome" class="bg-white divide-y divide-gray-100">
                        <?php if (!empty($detalleTabla)): ?>
                            <?php foreach ($detalleTabla as $fila): ?>
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-3.5 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-800"><?= htmlspecialchars($fila['Área']) ?>
                                        </div>
                                        <div class="text-xs text-gray-400">Edificio: <?= htmlspecialchars($fila['Edificio']) ?>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3.5 whitespace-nowrap">
                                        <div class="text-sm text-gray-700"><?= htmlspecialchars($fila['Computadora']) ?></div>
                                    </td>
                                    <td class="px-6 py-3.5 whitespace-nowrap text-sm text-gray-700">
                                        <?= htmlspecialchars($fila['Licencia']) ?>
                                    </td>
                                    <td class="px-6 py-3.5 whitespace-nowrap font-mono text-xs text-gray-500">
                                        <?= htmlspecialchars($fila['Código']) ?>
                                    </td>
                                    <td class="px-6 py-3.5 whitespace-nowrap">
                                        <span class="text-xs px-2 py-0.5 rounded-md bg-amber-50 text-amber-800 font-medium">
                                            <?= htmlspecialchars($fila['Vence El']) ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-400">No hay licencias ni
                                    equipos vinculados por el momento.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // 1. Configuración Gráfico de Barras Dinámico (8 columnas)
    const ctxBar = document.getElementById('barChartLicencias').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: <?= json_encode($categoriasLabels) ?>,
            datasets: [{
                label: 'Cantidad de Licencias',
                data: <?= json_encode($categoriasValores) ?>,
                backgroundColor: '#2CA1C8',
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { color: '#E5E7EB' }, ticks: { color: '#9CA3AF' } },
                x: { grid: { display: false }, ticks: { color: '#9CA3AF' } }
            }
        }
    });

    // 2. Configuración Gráfico de Pastel Dinámico (4 columnas)
    const ctxPie = document.getElementById('pieChartEstados').getContext('2d');
    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: <?= json_encode($estadosLabels) ?>, // Inyección limpia desde PHP
            datasets: [{
                data: <?= json_encode($estadosValores) ?>, // Inyección limpia desde PHP
                backgroundColor: ['#2CA1C8', '#1E85A8', '#89D4EA'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 12, color: '#4B5563', font: { size: 11 } }
                }
            }
        }
    });
</script>

<script>
    const buscadorEquiposHome = document.getElementById('buscarEquipoHome');
    const filasEquiposHome = document.querySelectorAll('#tablaEquiposHome tr');

    if (buscadorEquiposHome) {
        buscadorEquiposHome.addEventListener('input', () => {
            const termino = buscadorEquiposHome.value.toLowerCase().trim();

            filasEquiposHome.forEach((fila) => {
                const coincide = fila.textContent.toLowerCase().includes(termino);
                fila.style.display = coincide ? '' : 'none';
            });
        });
    }
</script>

<?php include 'inc/Footer.php'; ?>