<?php include __DIR__ . '/../inc/Header.php'; ?>
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-12">

    <div class="flex items-center gap-4">
        <div class="p-3 bg-[#2CA1C8]/10 rounded-2xl text-[#2CA1C8]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
            </svg>
        </div>

        <div>
            <h1 class="text-2xl font-bold text-[#0C3B4C]">Gestión de Licencias</h1>
            <p class="text-sm text-gray-500 font-medium mt-1">Administra el inventario de licencias de software.</p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <!-- BOTÓN MODIFICADO PARA ABRIR EL MODAL PRINCIPAL -->
        <button onclick="abrirModal('modalLicencia', true)"
            class="flex items-center gap-2 bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Nueva Licencia
        </button>
    </div>

</div>


<!-- CARDS ESTADÍSTICAS -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Card Instaladas -->
    <div
        class="bg-white rounded-xl border border-gray-200 py-2.5 px-4 shadow-sm flex flex-col justify-between min-h-[90px]">
        <div class="flex items-center justify-between gap-2">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Licencias
                Instaladas</span>
            <span
                class="text-[10px] px-2 py-0.5 rounded-md bg-green-50 text-green-700 font-bold whitespace-nowrap">Vigente</span>
        </div>
        <div class="flex items-baseline gap-2 mt-1">
            <!-- SE AGREGÓ ID -->
            <p id="licenciasVigentesCount" class="text-2xl font-bold" style="color:#1E85A8;">0</p>
            <p class="text-[11px] text-gray-400 font-medium truncate">Operando correctamente ...</p>
        </div>
    </div>

    <!-- Card Disponibles -->
    <div
        class="bg-white rounded-xl border border-gray-200 py-2.5 px-4 shadow-sm flex flex-col justify-between min-h-[90px]">
        <div class="flex items-center justify-between gap-2">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">No instalada</span>
            <span class="text-[10px] px-2 py-0.5 rounded-md bg-blue-50 text-blue-700 font-bold whitespace-nowrap">En
                espera</span>
        </div>
        <div class="flex items-baseline gap-2 mt-1">
            <!-- SE AGREGÓ ID -->
            <p id="licenciasDisponiblesCount" class="text-2xl font-bold" style="color:#1E85A8;">0</p>
            <p class="text-[11px] text-gray-400 font-medium truncate">Listas para ser instaladas ...</p>
        </div>
    </div>

    <!-- Card Expiradas -->
    <div
        class="bg-white rounded-xl border border-gray-200 py-2.5 px-4 shadow-sm flex flex-col justify-between min-h-[90px]">
        <div class="flex items-center justify-between gap-2">
            <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider truncate">Expiradas /
                Vencidas</span>
            <span
                class="text-[10px] px-2 py-0.5 rounded-md bg-red-50 text-red-700 font-bold whitespace-nowrap">Renovar</span>
        </div>
        <div class="flex items-baseline gap-2 mt-1">
            <!-- SE AGREGÓ ID -->
            <p id="licenciasExpiradasCount" class="text-2xl font-bold" style="color:#1E85A8;">0</p>
            <p class="text-[11px] text-gray-400 font-medium truncate">Requieren renovación ...</p>
        </div>
    </div>
</div>

<div class="flex-1 overflow-y-auto p-6 mt-6 flex flex-col gap-6" style="background:#F4F8FA;">
    <!-- TABLA DE LICENCIAS -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex-1 flex flex-col">

        <!-- Header tabla -->
        <div class="px-5 py-4 border-b border-gray-200 bg-white">

            <div class="flex items-center justify-between gap-4">

                <!-- Título -->
                <div>
                    <h2 class="text-sm font-semibold text-gray-800">
                        Inventario Global de Licencias
                    </h2>

                    <p class="text-xs text-gray-400">
                        Software registrado, claves de producto y asignaciones
                    </p>
                </div>

                <!-- Buscador + filtro -->
                <div class="flex items-center gap-3 flex-1 justify-end">

                    <!-- Barra de búsqueda -->
                    <div class="relative w-full max-w-2xl">

                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">

                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>

                        <input id="buscarLicencia" type="text" placeholder="Buscar licencia, software o clave..."
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 placeholder:text-gray-400 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">
                    </div>

                    <!-- Filtro -->
                    <div
                        class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-2 whitespace-nowrap">

                        <label for="filtro-estado" class="text-xs font-semibold text-gray-500 uppercase tracking-wide">
                            Estado
                        </label>

                        <select id="filtro-estado"
                            class="bg-transparent text-sm text-gray-700 focus:outline-none cursor-pointer">

                            <option value="">Todos</option>
                            <option value="Instalada">Instalada </option>
                            <option value="noinstalada">No Instalada</option>
                            <option value="Expirada">Expirada</option>

                        </select>

                    </div>

                </div>

            </div>

        </div>

    </div>


</div>
</div>


<div class="overflow-x-hidden">
    <table class="w-full table-fixed divide-y divide-gray-200 align-middle">
        <thead>
            <tr class="bg-gray-50">
                <th class="px-3 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                    Software / Tipo
                </th>

                <th class="px-3 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                    Código de Licencia
                </th>

                <th class="px-3 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                    Capacidad (Activas/Máx)
                </th>

                <th class="px-3 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                    Equipo Asignado
                </th>

                <th class="px-3 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                    Vencimiento
                </th>

                <th class="px-3 py-3 text-left text-xs font-medium text-gray-400 uppercase tracking-wider">
                    Estado
                </th>

                <th class="px-3 py-3 text-center text-xs font-medium text-gray-400 uppercase tracking-wider">
                    Acciones
                </th>
            </tr>
        </thead>

        <tbody class="bg-white divide-y divide-gray-100">

            <?php if (!empty($licencias)): ?>

                <?php foreach ($licencias as $licencia): ?>

                    <tr data-search="<?php echo htmlspecialchars(strtolower($licencia['nombreTipoLicencia'] . ' ' . $licencia['codigoLicencia'] . ' ' . $licencia['estadoLicencia']), ENT_QUOTES, 'UTF-8'); ?>"
                        data-estado="<?php echo htmlspecialchars(strtolower($licencia['estadoLicencia']), ENT_QUOTES, 'UTF-8'); ?>">

                        <!-- SOFTWARE -->
                        <td class="px-3 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-2">

                                <div
                                    class="flex-shrink-0 h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-xs">

                                    <?php echo strtoupper(substr($licencia['nombreTipoLicencia'], 0, 2)); ?>

                                </div>

                                <div>
                                    <p class="text-sm font-semibold text-gray-800">
                                        <?php echo htmlspecialchars($licencia['nombreTipoLicencia']); ?>
                                    </p>

                                    <p class="text-xs text-gray-400">
                                        Categoría de software
                                    </p>
                                </div>

                            </div>
                        </td>

                        <!-- CÓDIGO -->
                        <td class="px-3 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <code class="font-mono text-xs bg-gray-100 border border-gray-200 px-2 py-1 rounded-xl text-gray-700 product-key" data-key="<?php echo htmlspecialchars($licencia['codigoLicencia']); ?>">••••••••</code>
                                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors toggle-key-visibility cursor-pointer" aria-label="Mostrar clave">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                            </div>
                            <p class="text-xs text-gray-400 mt-1">
                                Clave de producto
                            </p>
                        </td>

                        <!-- CAPACIDAD -->
                        <td class="px-3 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <?php 
                                $totalAsignados = (int)($licencia['totalAsignados'] ?? 0);
                                $numPermitVinculados = (int)($licencia['numPermitVinculados'] ?? 1);
                                if ($numPermitVinculados < 1) $numPermitVinculados = 1;
                                $porcentaje = round(($totalAsignados / $numPermitVinculados) * 100);
                                $colorProgreso = 'bg-cyan-500';
                                if ($totalAsignados >= $numPermitVinculados) {
                                    $colorProgreso = 'bg-red-500';
                                }
                                ?>
                                <span class="text-sm font-semibold text-gray-700">
                                    <?php echo $totalAsignados; ?> / <?php echo $numPermitVinculados; ?>
                                </span>
                            </div>
                            <div class="w-24 bg-gray-200 rounded-full h-1.5 mt-1 overflow-hidden">
                                <div class="<?php echo $colorProgreso; ?> h-1.5 rounded-full" style="width: <?php echo min($porcentaje, 100); ?>%"></div>
                            </div>
                        </td>

                        <!-- EQUIPO -->
                        <td class="px-3 py-3">
                            <?php if (!empty($licencia['computadorasAsignadas'])): ?>
                                <ul class="list-disc list-inside text-xs text-green-700 font-medium space-y-0.5">
                                    <?php foreach (explode('||', $licencia['computadorasAsignadas']) as $comp): ?>
                                        <li><?php echo htmlspecialchars($comp); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <span class="text-xs text-red-500 font-semibold">
                                    Sin equipos asignados
                                </span>
                            <?php endif; ?>
                            <p class="text-xs text-gray-400 mt-1">
                                Equipos vinculados
                            </p>
                        </td>

                        <!-- FECHA -->
                        <td class="px-3 py-3 whitespace-nowrap">

                            <p class="text-sm text-gray-700">

                                <?php
                                if (!empty($licencia['fechaCaducacion']) && $licencia['fechaCaducacion'] !== '0000-00-00') {

                                    $fecha = new DateTime($licencia['fechaCaducacion']);
                                    echo $fecha->format('d M Y');

                                } else {

                                    echo 'Sin fecha de vencimiento';
                                }
                                ?>

                            </p>

                            <p class="text-xs text-gray-400">
                                Fecha de vencimiento
                            </p>

                        </td>

                        <!-- ESTADO -->
                        <td class="px-3 py-3 whitespace-nowrap">

                            <?php

                            $estado = $licencia['estadoLicencia'];

                            $estadoMostrar = str_replace('NoInstalada', 'No instalada', $estado);

                            $color = 'gray';

                            if ($estado === 'Instalada') {

                                $color = 'green';

                            } elseif ($estado === 'Expirada') {

                                $color = 'red';

                            } elseif ($estado === 'NoInstalada') {

                                $color = 'blue';
                            }

                            ?>

                            <span
                                class="text-[10px] px-2 py-0.5 rounded-md bg-<?php echo $color; ?>-50 text-<?php echo $color; ?>-700 font-bold whitespace-nowrap">

                                <?php echo htmlspecialchars($estadoMostrar); ?>

                            </span>

                        </td>

                        <!-- ACCIONES -->
                        <td class="px-3 py-3 whitespace-nowrap text-center">

                            <button type="button"
                                class="inline-flex items-center justify-center p-2 rounded-lg bg-cyan-50 text-[#2CA1C8] hover:bg-cyan-100 transition-all cursor-pointer"
                                title="Editar licencia" aria-label="Editar licencia"
                                data-id="<?php echo (int) $licencia['idLicencia']; ?>"
                                data-tipo="<?php echo (int) $licencia['idTipoLicencia']; ?>"
                                data-codigo="<?php echo htmlspecialchars($licencia['codigoLicencia'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-estado="<?php echo htmlspecialchars($licencia['estadoLicencia'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-fechaadq="<?php echo htmlspecialchars($licencia['fechaAdquisision'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-fechacad="<?php echo htmlspecialchars($licencia['fechaCaducacion'], ENT_QUOTES, 'UTF-8'); ?>"
                                data-numpermit="<?php echo (int) ($licencia['numPermitVinculados'] ?? 1); ?>"
                                onclick="prepararEdicion(this)">

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">

                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487a2.75 2.75 0 113.889 3.89L8.25 20.878 3 22l1.122-5.25L16.862 4.487z" />

                                </svg>

                            </button>

                        </td>

                    </tr>

                <?php endforeach; ?>

                <tr id="sinResultadosLicencias" class="hidden">

                    <td colspan="8" class="px-3 py-6 text-center text-sm text-gray-400">
                        No se encontraron licencias con esos criterios.
                    </td>

                </tr>

            <?php else: ?>

                <tr>

                    <td colspan="8" class="px-3 py-4 text-center text-xs text-gray-400">
                        No hay licencias registradas. ¡Agrega tu primera licencia!
                    </td>

                </tr>

            <?php endif; ?>

        </tbody>
    </table>
</div>
</div>

</div>

<!-- ========================================== -->
<!-- MODAL 1: AGREGAR NUEVA LICENCIA            -->
<!-- ========================================== -->
<div id="modalLicencia"
    class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs transition-all duration-300">
    <div
        class="bg-white rounded-2xl border border-gray-200 shadow-xl w-full max-w-lg overflow-hidden flex flex-col transform transition-all">

        <!-- Header Modal -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white">
            <div>
                <h3 id="encabesadoModal" name="encabesadoModal" class=" text-lg font-bold text-[#0C3B4C]">Registrar Nueva Licencia</h3>
                <p id="suptituloEcabesadoModal" class="text-xs text-gray-400">Llena los datos para añadir un software al inventario</p>
            </div>
            <button onclick="cerrarModal('modalLicencia')"
                class="text-gray-400 hover:text-gray-600 p-1.5 hover:bg-gray-100 rounded-xl transition-all">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Formulario -->
        <form id="formNuevaLicencia" class="p-6 flex flex-col gap-4">
            <input type="hidden" id="idLicencia" name="idLicencia" value="">
            <!-- Select de Tipo Licencia con Botón Integrado -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tipo de
                    Licencia</label>
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <select id="idTipoLicencia" name="idTipoLicencia" required
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#2CA1C8] focus:bg-white transition-all appearance-none">
                            <option value="" disabled selected>Selecciona un tipo...</option>

                            <?php if (!empty($tipodeLicencias)): ?>
                                <?php foreach ($tipodeLicencias as $tipo): ?>
                                    <!-- Almacenamos el ID en el value, y mostramos el nombre al usuario -->
                                    <option value="<?php echo $tipo['idTipoLicencia']; ?>">
                                        <?php echo htmlspecialchars($tipo['nombreTipoLicencia']); ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No hay tipos de licencia registrados</option>
                            <?php endif; ?>

                        </select>
                        <div
                            class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                    <!-- Botón para abrir el segundo modal -->
                    <button type="button" onclick="abrirSubModal()"
                        class="bg-[#2CA1C8]/10 hover:bg-[#2CA1C8]/20 text-[#2CA1C8] px-3.5 rounded-xl font-medium text-sm transition-all flex items-center justify-center gap-1 cursor-pointer"
                        title="Gestionar Tipos">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Código de Licencia -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Código / Clave de
                    Licencia</label>
                <input type="text" id="codigoLicencia" name="codigoLicencia" required
                    placeholder="Ej: XXXXX-XXXXX-XXXXX-XXXXX"
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-mono focus:outline-none focus:border-[#2CA1C8] focus:bg-white transition-all">
            </div>

            <!-- Capacidad de Licencia (numPermitVinculados) -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Capacidad Máxima de Equipos Vinculados (Activaciones)</label>
                <input type="number" id="numPermitVinculados" name="numPermitVinculados" required min="1" value="1"
                    placeholder="Ej: 5"
                    class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-[#2CA1C8] focus:bg-white transition-all">
            </div>

            <!-- Estado Licencia (ENUM) -->
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Estado
                    Inicial</label>
                <div class="relative">
                    <select id="estadoLicencia" name="estadoLicencia" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#2CA1C8] focus:bg-white transition-all appearance-none">
                        <option value="Instalada" >Instalada</option>
                        <option value="Expirada">Expirada</option>
                        <option value="NoInstalada" selected>No instalada</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Fechas -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Fecha Adquisición -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Fecha de Adquisición
                    </label>

                    <input type="date" id="fechaAdquisision" name="fechaAdquisision" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#2CA1C8] focus:bg-white transition-all">
                </div>

                <!-- Fecha Caducación -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Fecha de Caducación
                    </label>

                    <input type="date" id="fechaCaducacion" name="fechaCaducacion" required
                        class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#2CA1C8] focus:bg-white transition-all">
                </div>

            </div>

            <!-- Botones Acciones -->
            <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-gray-100">
                <button type="button" onclick="cerrarModal('modalLicencia')"
                    class="px-4 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-all cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Cancelar
                </button>
                <button type="submit" id="btnSubmitLicencia"
                    class="inline-flex items-center gap-2 bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md transition-all cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 16h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v7a2 2 0 002 2h2m3 4h4m-2-4v4m-7-8h10" />
                    </svg>
                    Guardar Licencia
                </button>
            </div>
        </form>
    </div>
</div>


<!-- ========================================== -->
<!-- MODAL 2: GESTIONAR TIPOS DE LICENCIAS       -->
<!-- ========================================== -->
<div id="modalTipoLicencia"
    class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs transition-all duration-300">
    <div
        class="bg-white rounded-2xl border border-gray-200 shadow-xl w-full max-w-xl overflow-hidden flex flex-col transform transition-all">

        <!-- Header Modal -->
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white">
            <div>
                <h3 class="text-lg font-bold text-[#0C3B4C]">Gestionar Tipos de Licencias</h3>
                <p class="text-xs text-gray-400">Agrega, edita o remueve las categorías de software</p>
            </div>
            <button onclick="cerrarSubModal()"
                class="text-gray-400 hover:text-gray-600 p-1.5 hover:bg-gray-100 rounded-xl transition-all">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <div class="p-6 flex flex-col gap-6">
            <!-- Mini Formulario -->
            <form id="formNuevoTipo"
                class="bg-gray-50 border border-gray-100 p-4 rounded-xl flex flex-col gap-3">
                <input type="hidden" id="idTipoLicenciaTipo" name="idTipoLicencia" value="">

                <div class="flex flex-col sm:flex-row gap-3 w-full items-end">
                    <div class="flex-1 w-full">
                        <label id="labelFormTipo"
                            class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Nuevo Tipo de Licencia
                        </label>
                        <input type="text" id="nombreTipoLicencia" name="nombreTipoLicencia" required
                            placeholder="Ej: Diseño Gráfico"
                            class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-[#2CA1C8] transition-all">
                    </div>

                    <div class="flex-1 w-full relative">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                            Categoría
                        </label>
                        <select id="categoriaLicencia" name="categoriaLicencia" required
                            class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm text-gray-700 focus:outline-none focus:border-[#2CA1C8] transition-all appearance-none">
                            <option value="" disabled selected>Categoría...</option>
                            <option value="SO">Sistemas Operativos (SO)</option>
                            <option value="Office">Office</option>
                            <option value="Antivirus">Antivirus</option>
                            <option value="Otros">Otros</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400 pt-7">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex gap-2 w-full justify-end mt-2">
                    <button type="button" id="btnCancelarEdicion" onclick="limpiarFormularioTipo()"
                        class="hidden bg-gray-300 text-gray-700 px-3 py-2 rounded-xl font-semibold text-sm h-[38px] cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancelar
                    </button>
                    <button type="submit" id="btnSubmitTipo"
                        class="bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-5 py-2 rounded-xl font-semibold text-sm transition-all h-[38px] cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Añadir
                    </button>
                </div>
            </form>

            <!-- Tabla de Tipos Existentes -->
            <div class="flex flex-col">
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Categorías Registradas</label>
                <div class="border border-gray-200 rounded-xl overflow-hidden max-h-52 overflow-y-auto bg-white">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php if (!empty($tipodeLicencias)): ?>
                                <?php foreach ($tipodeLicencias as $tipo): ?>
                                    <tr>
                                        <td class="px-4 py-2.5 text-gray-700 font-medium">
                                            <?php echo htmlspecialchars($tipo['nombreTipoLicencia']); ?>
                                            <span class="ml-2 text-[10px] px-2 py-0.5 rounded-full bg-cyan-50 text-[#2CA1C8] font-bold border border-cyan-100">
                                                <?php echo htmlspecialchars($tipo['categoriaLicencia'] ?? 'Otros'); ?>
                                            </span>
                                        </td>
                                        <td class="px-4 py-2.5 text-right">
                                            <!-- Pasamos el ID, el nombre y la categoría real de la base de datos a las funciones de JS -->
                                            <button type="button"
                                                onclick='editarTipo(<?php echo (int) $tipo["idTipoLicencia"]; ?>, <?php echo json_encode($tipo["nombreTipoLicencia"], JSON_HEX_APOS | JSON_HEX_QUOT); ?>, <?php echo json_encode($tipo["categoriaLicencia"] ?? "", JSON_HEX_APOS | JSON_HEX_QUOT); ?>)'
                                                class="inline-flex items-center justify-center p-2 rounded-lg bg-cyan-50 text-[#2CA1C8] hover:bg-cyan-100 transition-all mr-2 cursor-pointer"
                                                title="Editar tipo de licencia" aria-label="Editar tipo de licencia">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487a2.75 2.75 0 113.889 3.89L8.25 20.878 3 22l1.122-5.25L16.862 4.487z" />
                                                </svg>
                                            </button>
                                            <button type="button"
                                                onclick="confirmEliminar(<?php echo (int) $tipo['idTipoLicencia']; ?>)"
                                                class="inline-flex items-center justify-center p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-all cursor-pointer"
                                                title="Eliminar tipo de licencia" aria-label="Eliminar tipo de licencia">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m-4 0h14" />
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="px-4 py-4 text-center text-xs text-gray-400">
                                        No hay categorías registradas.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Footer SubModal -->
        <div class="px-6 py-3 bg-gray-50 flex justify-end border-t border-gray-100">
            <button type="button" onclick="cerrarSubModal()"
                class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-xl font-semibold text-xs transition-all cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Regresar a Licencia
            </button>
        </div>
    </div>
</div>

<script>window.BASE_URL = '<?= BASE_URL ?>';</script>
<script src="<?= BASE_URL ?>/assets/js/licencias.js?v=<?= time() ?>"></script>
<script src="<?= BASE_URL ?>/assets/js/tipos_licencias.js?v=<?= time() ?>"></script>

<?php include __DIR__ . '/../inc/Footer.php'; ?>