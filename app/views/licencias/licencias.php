<?php include __DIR__ . '/../inc/Header.php'; ?>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-12">

        <div class="flex items-center gap-4">
            <div class="p-3 bg-[#2CA1C8]/10 rounded-2xl text-[#2CA1C8]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                </svg>
            </div>

            <div>
                <h1 class="text-2xl font-bold text-[#0C3B4C]">Gestión de Licencias</h1>
                <p class="text-sm text-gray-500 font-medium mt-1">Administra el inventario de licencias de software.</p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">

            <a href="#" class="flex items-center gap-2 bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nueva Licencia
            </a>
        </div>

    </div>

    <div class="flex-1 overflow-y-auto p-6 flex flex-col gap-6" style="background:#F4F8FA;">

        <!-- CARDS ESTADÍSTICAS -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <!-- Card 1: Licencias Vigentes -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Licencias Vigentes</span>
                    <span class="text-xs px-2 py-0.5 rounded-lg bg-green-50 text-green-700 font-medium">Activas</span>
                </div>
                <p class="text-3xl font-semibold" style="color:#1E85A8;">184</p>
                <p class="text-xs text-gray-400 mt-1">Operando correctamente en equipos</p>
            </div>

            <!-- Card 2: Licencias Libres (No Instaladas) -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Disponibles</span>
                    <span class="text-xs px-2 py-0.5 rounded-lg bg-blue-50 text-blue-700 font-medium">Sin usar</span>
                </div>
                <p class="text-3xl font-semibold" style="color:#1E85A8;">50</p>
                <p class="text-xs text-gray-400 mt-1">Listas para ser instaladas en computadoras</p>
            </div>

            <!-- Card 3: Licencias Expiradas -->
            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Expiradas / Vencidas</span>
                    <span class="text-xs px-2 py-0.5 rounded-lg bg-red-50 text-red-700 font-medium">Requieren Acción</span>
                </div>
                <p class="text-3xl font-semibold text-red-600">14</p>
                <p class="text-xs text-gray-400 mt-1">Requieren renovación o desinstalación</p>
            </div>

        </div>

        <!-- TABLA DE LICENCIAS -->
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex-1 flex flex-col">

            <!-- Header tabla -->
            <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between bg-white">
                <div>
                    <h2 class="text-sm font-semibold text-gray-800">Inventario Global de Licencias</h2>
                    <p class="text-xs text-gray-400">Software registrado, claves de producto y asignaciones</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 align-middle">
                    <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Software / Tipo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Código de Licencia</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Equipo Asignado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Vencimiento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">

                    <!-- Fila de ejemplo estática (Quítala cuando actives el loop PHP) -->
                    <tr>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-800">Windows 11 Pro</div>
                            <div class="text-xs text-gray-400">Sistema Operativo</div>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap text-sm font-mono text-gray-600">
                            <span class="bg-gray-100 px-2 py-1 rounded">W269N-WFGWX-YVC9B-XXXXX</span>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <div class="text-sm text-gray-700">Dell OptiPlex (S/N: SN-874291)</div>
                            <div class="text-xs text-gray-400">Área: Centro de Cómputo A</div>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap text-sm text-gray-600">
                            12/12/2026
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium bg-green-50 text-green-700">Vigente</span>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center gap-3">
                                <a href="editar_licencia.php?id=1" class="hover:underline" style="color:#2CA1C8;">Editar</a>
                                <button class="text-red-600 hover:underline">Eliminar</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div><!-- /TABLA -->

    </div>

<?php include __DIR__ . '/../inc/Footer.php'; ?>