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
                                case 'desactiva':
                                    $claseBadge = 'bg-red-50 text-red-700 border-red-200';
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
                        <td class="px-6 py-3.5 whitespace-nowrap text-center text-sm font-medium">
                            <div class="flex items-center justify-center gap-3">
                                <button class="text-[#2CA1C8] hover:underline">Detalles</button>

                                <a href="<?= BASE_URL ?>/equipos/area/edit?idArea=<?= $infoArea['idArea'] ?>&idEquipo=<?= $computadora['idComputadora'] ?>"
                                   class="text-[#2CA1C8] hover:underline">
                                    Editar
                                </a>

                                <a href="<?= BASE_URL ?>/equipos/area/delete?idEquipo=<?= $computadora['idComputadora'] ?>&idArea=<?= $infoArea['idArea'] ?>"
                                   class="text-red-600 hover:underline">
                                    Eliminar
                                </a>
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

<?php include __DIR__ . '/../inc/Footer.php'; ?>
