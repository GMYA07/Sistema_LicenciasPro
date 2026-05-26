<?php include __DIR__ . '/../inc/Header.php'; ?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-12">

    <div class="flex items-center gap-4">
        <div class="p-3 bg-[#2CA1C8]/10 rounded-2xl text-[#2CA1C8]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>

        <div>
            <h1 class="text-2xl font-bold text-[#0C3B4C]">Gestión de Equipos - <?= $infoArea['nombreArea'] ?></h1>
            <p class="text-sm text-gray-500 font-medium mt-1">Administra el inventario de computadoras.</p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">

        <a href="<?= BASE_URL ?>/equipos"
           class="flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-600 border border-gray-200 px-5 py-2.5 rounded-xl font-medium text-sm shadow-sm transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Volver a Áreas
        </a>

        <a href="<?= BASE_URL ?>/equipos/area/create?idArea=<?= $infoArea['idArea'] ?>"
           class="flex items-center gap-2 bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            Nuevo Equipo
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex-1 flex flex-col">

    <!-- Header tabla -->
    <div class="px-5 py-4 border-b border-gray-200 flex items-center justify-between bg-white">
        <div>
            <h2 class="text-sm font-semibold text-gray-800">Inventario de las computadoras</h2>
            <p class="text-xs text-gray-400">Total de equipos registrados en el área</p>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 align-middle">
            <thead>
            <tr class="bg-gray-50">
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Marca /
                    Modelo
                </th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Serial</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">Estado</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">Acciones
                </th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
            <?php if (!empty($computadoras)): ?>

                <?php foreach ($computadoras as $computadora): ?>
                    <tr>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-800">
                                <?= htmlspecialchars($computadora['Marca']) ?>
                                / <?= htmlspecialchars($computadora['Modelo']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-800">
                                <?= htmlspecialchars($computadora['Serial']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap">
                            <?php
                            $claseBadge = '';
                            $textoEstado = ucfirst(htmlspecialchars($computadora['estadoComputadora']));
                            switch ($computadora['estadoComputadora']) {
                                case 'activa':
                                    $claseBadge = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                                    break;
                                case 'mantenimiento':
                                    $claseBadge = 'bg-amber-50 text-amber-700 border-amber-200';
                                    break;
                                default: // Por si acaso llega un dato raro o vacío
                                    $claseBadge = 'bg-gray-50 text-gray-700 border-gray-200';
                                    break;
                            }
                            ?>
                            <span class="text-xs px-2.5 py-1 rounded-full font-medium border <?= $claseBadge ?>">
                                <?= $textoEstado ?>
                            </span>
                        </td>
                        <td class="px-6 py-3.5 whitespace-nowrap text-center">
                            <div class="flex items-center justify-center gap-2">

                                <button type="button"
                                        title="Gestionar Licencias"
                                        onclick="abrirModalLicencias(<?= $computadora['idComputadora'] ?>)"
                                        class="p-2 text-gray-400 hover:text-[#2CA1C8] hover:bg-[#2CA1C8]/10 rounded-lg transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                                    </svg>
                                </button>

                                <a href="<?= BASE_URL ?>/equipos/area/edit?idArea=<?= $infoArea['idArea'] ?>&idEquipo=<?= $computadora['idComputadora'] ?>" title="Editar Equipo" class="p-2 text-gray-400 hover:text-[#2CA1C8] hover:bg-[#2CA1C8]/10 rounded-lg transition-all duration-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </a>

                                <form id="formEliminar_<?= $computadora['idComputadora'] ?>" action="<?= BASE_URL ?>/equipos/area/delete" method="POST" class="inline-block m-0">
                                    <input type="hidden" name="idComputadora" value="<?= $computadora['idComputadora'] ?>">
                                    <input type="hidden" name="idArea" value="<?= $infoArea['idArea'] ?>">
                                    <button type="button"
                                            onclick="confirmarEliminacion(<?= $computadora['idComputadora'] ?>)"
                                            title="Eliminar Equipo"
                                            class="p-2 text-gray-400 cursor-pointer hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200">

                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>

            <?php else: ?>
                <tr>
                    <td colspan="4" class="px-6 py-8 whitespace-nowrap text-center">
                        <div class="flex flex-col items-center justify-center text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2 text-gray-300" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-sm font-medium">No hay equipos registrados en esta área.</span>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

</div>

<?php include __DIR__ . "/modalGestionLicencias.php"; ?>

<?php include __DIR__ . '/../inc/Footer.php'; ?>
