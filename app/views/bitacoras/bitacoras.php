<?php include __DIR__ . '/../inc/Header.php'; ?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-12">

    <div class="flex items-center gap-4">
        <div class="p-3 bg-[#2CA1C8]/10 rounded-2xl text-[#2CA1C8]">
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-8 w-8" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
            </svg>
        </div>

        <div>
            <h1 class="text-2xl font-bold text-[#0C3B4C]">Gestión de Bitácoras</h1>
            <p class="text-sm text-gray-500 font-medium mt-1">Administra el registro de actividades del sistema.</p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <a href="<?= BASE_URL ?>/bitacoras/create"
           class="flex items-center gap-2 bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Nueva Bitacora
        </a>
    </div>

</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex-1 flex flex-col mt-6">

    <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between bg-white">
        <div>
            <h2 class="text-sm font-semibold text-gray-800">Historial de Bitácoras</h2>
            <p class="text-xs text-gray-400">Registro de bitacoras y estado de licencias general por área</p>
        </div>

        <div class="flex items-center gap-3 flex-1 justify-end">
            <div class="relative w-full max-w-xl">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input id="searchInputBitacoras" type="text" placeholder="Buscar por área, fecha o tecnico..."
                       class="w-full bg-gray-50 border border-gray-200 text-gray-700 placeholder:text-gray-400 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#2CA1C8]/20 focus:border-[#2CA1C8] transition">
            </div>
        </div>
    </div>

    <div class="overflow-x-auto overflow-y-auto max-h-[500px] scroll-elegante">
        <table id="bitacorasTable" class="min-w-full divide-y divide-gray-200 align-middle">
            <thead class="bg-gray-50 sticky top-0 z-10 shadow-sm">
            <tr class="bg-gray-50">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Área Inspeccionada</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Fecha y Hora</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Técnico</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Resumen de Equipos</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones</th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">

            <?php if (!empty($bitacoras)): ?>
                <?php foreach ($bitacoras as $bitacora): ?>
                    <tr class="hover:bg-gray-50/50 transition-colors">

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="h-8 w-8 rounded-lg bg-[#2CA1C8]/10 flex items-center justify-center text-[#2CA1C8]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="text-sm font-bold text-gray-800">
                                    <?= htmlspecialchars($bitacora['nombreArea']) ?>
                                </div>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-700">
                                <?= date('d/m/Y', strtotime($bitacora['fechaRevision'])) ?>
                            </div>
                            <div class="text-xs text-gray-400">
                                <?= date('h:i A', strtotime($bitacora['fechaRevision'])) ?>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-600 font-medium">
                                <?= htmlspecialchars($bitacora['usuario'] ?? 'Desconocido') ?>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">
                                <span title="Total Equipos" class="text-[10px] px-2 py-1 rounded-md font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                    Tot: <?= $bitacora['totalEquipos'] ?>
                                </span>
                                <span title="Con Licencia" class="text-[10px] px-2 py-1 rounded-md font-bold bg-[#2CA1C8]/10 text-[#2CA1C8] border border-[#2CA1C8]/20">
                                    Con: <?= $bitacora['equiposConLicencia'] ?>
                                </span>
                                <span title="Sin Licencia" class="text-[10px] px-2 py-1 rounded-md font-bold bg-red-50 text-red-500 border border-red-100">
                                    Sin: <?= $bitacora['equiposSinLicencia'] ?>
                                </span>
                            </div>
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-3">
                                <a href="<?= BASE_URL ?>/bitacoras/imprimir?idBitacora=<?= $bitacora['idBitacora'] ?>" target="_blank"
                                   title="Imprimir Reporte PDF"
                                   class="flex items-center gap-1.5 px-3 py-1.5 bg-[#2CA1C8] hover:bg-[#1E85A8] text-white text-xs font-semibold rounded-lg shadow-sm transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                                    </svg>
                                    PDF
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <tr id="sinResultadosBitacoras" class="hidden">
                    <td colspan="5" class="px-6 py-6 text-center text-sm text-gray-400">
                        No se encontraron bitácoras con esos criterios.
                    </td>
                </tr>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 whitespace-nowrap text-center">
                        <div class="flex flex-col items-center justify-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-sm font-medium">Aún no hay reportes de bitácora registrados.</span>
                            <a href="<?= BASE_URL ?>/bitacoras/create" class="mt-3 text-xs text-[#2CA1C8] font-semibold hover:underline">
                                Crear primera bitácora
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<script src="<?=BASE_URL?>/assets/js/bitacoras.js"></script>

<?php include __DIR__ . '/../inc/Footer.php'; ?>
