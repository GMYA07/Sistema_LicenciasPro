<?php include 'inc/Header.php'; ?>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-12">

        <div class="flex items-center gap-4">
            <div class="p-3 bg-[#2CA1C8]/10 rounded-2xl text-[#2CA1C8]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
                </svg>
            </div>

            <div>
                <h1 class="text-2xl font-bold text-[#0C3B4C]">Gestión de Licencias de equipos</h1>
                <p class="text-sm text-gray-500 font-medium mt-1">Sitema creado para administracion de licencais de computadoras.</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <!--Para agregar botones si despues aqui seria para administrar areas-->
        </div>

    </div>
    <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-6" style="background:#F4F8FA;">

        <!-- CARDS ESTADÍSTICAS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Card 1: Licencias Vigentes -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Licencias Vigentes</span>
                    <span class="text-xs px-2 py-0.5 rounded-lg bg-green-50 text-green-700 font-medium">En uso</span>
                </div>
                <p class="text-3xl font-semibold" style="color:#1E85A8;">248</p>
                <p class="text-xs text-gray-400 mt-1">Instaladas en equipos activos</p>
            </div>

            <!-- Card 2: Total Equipos -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Equipos Registrados</span>
                    <span class="text-xs px-2 py-0.5 rounded-lg bg-blue-50 text-blue-700 font-medium">Total</span>
                </div>
                <p class="text-3xl font-semibold" style="color:#1E85A8;">87</p>
                <p class="text-xs text-gray-400 mt-1">Distribuidos en 6 áreas físicas</p>
            </div>

            <!-- Card 3: Vencen pronto (Licencias_detalles) -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Alertas de Vencimiento</span>
                    <span class="text-xs px-2 py-0.5 rounded-lg bg-amber-50 text-amber-700 font-medium animate-pulse">Atención</span>
                </div>
                <p class="text-3xl font-semibold text-amber-600">14</p>
                <p class="text-xs text-gray-400 mt-1">Licencias por caducar (próximos 30 días)</p>
            </div>

        </div>

        <!-- TABLA DE EQUIPOS -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex-1 flex flex-col">

            <!-- Header tabla -->
            <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between bg-white">
                <div>
                    <h2 class="text-sm font-semibold text-gray-800">Inventario de Equipos Recientes</h2>
                    <p class="text-xs text-gray-400">Estado actual de hardware y software asignado</p>
                </div>
                <a href="equipos.php" class="text-xs font-medium hover:underline" style="color:#2CA1C8;">Ver todos los equipos →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 align-middle">
                    <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Equipo / Modelo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Número de Serie</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Ubicación / Área</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">

                    <!-- Fila de ejemplo estática (Quítala cuando actives el loop PHP) -->
                    <tr>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-800">Dell OptiPlex</div>
                            <div class="text-xs text-gray-400">Modelo: 7090 Tower</div>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap text-sm font-mono text-gray-600">SN-874291-X</td>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <div class="text-sm text-gray-700">Centro de Cómputo A</div>
                            <div class="text-xs text-gray-400">Edificio: E-3</div>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-green-50 text-green-700">activa</span>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center gap-3">
                                <a href="editar_equipo.php?id=1" class="hover:underline" style="color:#2CA1C8;">Gestionar</a>
                                <button class="text-red-600 hover:underline">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div><!-- /TABLA -->

    </div><!-- /BODY -->

<?php include 'inc/Footer.php'; ?>