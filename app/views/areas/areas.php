<?php include __DIR__ . '/../inc/Header.php'; ?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-12">

    <div class="flex items-center gap-4">
        <div class="p-3 bg-[#2CA1C8]/10 rounded-2xl text-[#2CA1C8]">
    <svg xmlns="http://www.w3.org/2000/svg"
        class="h-8 w-8"
        fill="none"
        viewBox="0 0 24 24"
        stroke="currentColor"
        stroke-width="1.5">

        <path stroke-linecap="round"
            stroke-linejoin="round"
            d="M3 21h18M5 21V7a2 2 0 012-2h3V3h4v2h3a2 2 0 012 2v14M9 9h.01M9 13h.01M9 17h.01M15 9h.01M15 13h.01M15 17h.01" />
    </svg>
        </div>

        <div>
            <h1 class="text-2xl font-bold text-[#0C3B4C]">Gestión de Areas</h1>
            <p class="text-sm text-gray-500 font-medium mt-1">Administra las áreas de tu aplicación.</p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <!-- BOTÓN MODIFICADO PARA ABRIR EL MODAL PRINCIPAL -->
        <button onclick="abrirModal('modalArea')"
            class="flex items-center gap-2 bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Agregar Area
        </button>
    </div>

</div>

<div class="flex-1 overflow-y-auto mt-6 flex flex-col gap-6" style="background:#F4F8FA;">
    <!-- TABLA DE ÁREAS -->
    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden flex-1 flex flex-col">

        <!-- Header tabla -->
        <div class="px-5 py-4 border-b border-gray-200 bg-white">

            <div class="flex items-center justify-between gap-4">

                <!-- Título -->
                <div>
                    <h2 class="text-sm font-semibold text-gray-800">
                        Inventario Global de Áreas
                    </h2>

                    <p class="text-xs text-gray-400">
                        Áreas registradas y su información
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

                        <input id="searchInput" name="searchInput" type="text" placeholder="Buscar área..."
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 placeholder:text-gray-400 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>


<div class="bg-white rounded-2xl mt-4 border border-gray-200 shadow-sm overflow-hidden flex-1 flex flex-col">
    <!-- Tabla Responsive -->
    <div class="overflow-x-auto">
        <table id="areasTable" class="min-w-full divide-y divide-gray-200 align-middle">
            <thead>
                <tr class="bg-gray-50/75 border-b border-gray-200">
                    <th scope="col"
                        class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Nombre del Área
                    </th>
                    <th scope="col"
                        class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Ubicación (Edificio)
                    </th>
                    <th scope="col"
                        class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Equipos por area
                    </th>
                    <th scope="col"
                        class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Centro de Cómputo
                    </th>
                    <th scope="col"
                        class="px-6 py-3.5 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">

                <?php if (!empty($areas)): ?>
                    <?php foreach ($areas as $area): ?>
                        <tr class="hover:bg-gray-50/50 transition-colors duration-200">
                            <!-- Nombre del Área -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-800">
                                    <?= htmlspecialchars($area['nombreArea']) ?>
                                </div>
                                <div class="text-xs text-gray-400">
                                    ID Área: #<?= htmlspecialchars($area['idArea'] ?? 'N/A') ?>
                                </div>
                            </td>

                            <!-- Ubicación -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                    <?= htmlspecialchars($area['edificio']) ?>
                                </span>
                            </td>

                            <!-- Número de Equipos -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-semibold text-gray-700">
                                        <?= htmlspecialchars($area['numEquipos']) ?>
                                    </span>
                                    <span class="text-xs text-gray-400">unidades</span>
                                </div>
                            </td>

                            <!-- Centro de Cómputo (Badge Dinámico) -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?php if ($area['estadoCentroComputo']): ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200/50">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-green-500"></span>
                                        Activo
                                    </span>
                                <?php else: ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-gray-400"></span>
                                        Inactivo
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Acciones -->
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center gap-2">

                                    <button type="button" onclick='abrirModal("modalArea", {
                                                    idArea: <?= $area["idArea"] ?>,
                                                    nombreArea: "<?= addslashes($area["nombreArea"]) ?>",
                                                    edificio: "<?= addslashes($area["edificio"]) ?>",
                                                    numEquipos: <?= (int) $area["numEquipos"] ?>,
                                                    estadoCentroComputo: <?= $area["estadoCentroComputo"] ? 1 : 0 ?>
                                                })' class="text-gray-400 hover:text-blue-900 ...">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>

                                    <button type="button"
                                        onclick="abrirModalEliminacion('modalConfirmacion', <?= $area['idArea'] ?>)"
                                        class="text-gray-400 hover:text-red-600 ...">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-.667-.455-1.23-1.09-1.383a51.964 51.964 0 00-3.32-.397m0 .916c0 .667.455 1.23 1.09 1.383a51.964 51.964 0 003.32.397M9 12h3m3 0h3" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr id="sinResultadosAreas" class="hidden">
                        <td colspan="7" class="px-6 py-6 text-center text-sm text-gray-400">
                            No se encontraron áreas con esos criterios.
                        </td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-xs text-gray-400">
                            No hay áreas registradas. ¡Agrega tu primera área!
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>


<!-- MODAL PRINCIPAL PARA AGREGAR Y EDITAR ÁREAS -->
<!-- 
  Cambios clave en el contenedor:
  - 'invisible opacity-0 pointer-events-none' oculta el modal por defecto de forma segura.
  - 'transition-all duration-300 ease-out' y 'backdrop-blur-sm' crean el efecto de difuminado suave en el fondo.
-->
<div id="modalArea"
    class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center z-50 invisible opacity-0 pointer-events-none transition-all duration-300 ease-out">

    <div id="modalContentArea"
        class="bg-white rounded-2xl shadow-xl w-full max-w-md p-6 relative transform scale-95 opacity-0 transition-all duration-300 ease-out mx-4">

        <!-- Botón Cerrar (Esquina Superior) -->
        <button onclick="cerrarModal('modalArea')" type="button"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 hover:bg-gray-100 p-1.5 rounded-lg transition-all duration-200 cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <!-- Cabecera del Modal con Icono -->
        <div class="flex items-center gap-3 mb-5 border-b border-gray-100 pb-4">
            <div class="p-2 bg-[#2CA1C8]/10 rounded-xl text-[#2CA1C8]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
            <div>
                <h2 id="modalTitleArea" class="text-lg font-bold text-gray-800">Agregar Nueva Área</h2>
                <p class="text-xs text-gray-400">Completa los datos de infraestructura física</p>
            </div>
        </div>

        <!-- Formulario -->
        <form id="formArea" method="POST" action="<?= BASE_URL ?>/areas/guardar" class="space-y-4">
            <input type="hidden" name="idArea" id="idArea">

            <!-- Campo: Nombre del Área -->
            <div>
                <label for="nombreArea"
                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nombre del
                    Área</label>
                <input type="text" name="nombreArea" id="nombreArea" required placeholder="Ej. Laboratorio de Redes"
                    class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2CA1C8]/20 focus:border-[#2CA1C8] focus:bg-white transition-all duration-200">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Campo: Ubicación (Edificio) -->
                <div>
                    <label for="edificio"
                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Ubicación
                        (Edificio)</label>
                    <input type="text" name="edificio" id="edificio" required placeholder="Ej. B-3"
                        class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm font-mono text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2CA1C8]/20 focus:border-[#2CA1C8] focus:bg-white transition-all duration-200">
                </div>

                <!-- Campo: Número de Equipos -->
                <div>
                    <label for="numEquipos"
                        class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Número de
                        Equipos</label>
                    <input type="number" name="numEquipos" id="numEquipos" required min="0" placeholder="0"
                        class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2CA1C8]/20 focus:border-[#2CA1C8] focus:bg-white transition-all duration-200">
                </div>
            </div>

            <!-- Campo: Centro de Cómputo -->
            <div>
                <label for="estadoCentroComputo"
                    class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">¿Es Centro de
                    Cómputo?</label>
                <select name="estadoCentroComputo" id="estadoCentroComputo" required
                    class="w-full bg-gray-50/50 border border-gray-200 rounded-xl px-3.5 py-2.5 text-sm text-gray-800 focus:outline-none focus:ring-2 focus:ring-[#2CA1C8]/20 focus:border-[#2CA1C8] focus:bg-white transition-all duration-200 cursor-pointer">
                    <option value="1" class="text-gray-800">Activo</option>
                    <option value="0" class="text-gray-800">Inactivo</option>
                </select>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 mt-6">
                <button type="button" onclick="cerrarModal('modalArea')"
                    class="px-4 py-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-semibold border border-gray-200/50 transition-all duration-200 cursor-pointer">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-[#2CA1C8] text-white hover:bg-[#1E85A8] text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>



<!-- Modal para verificar eliminación -->
<div id="modalConfirmacion"
    class="fixed inset-0 bg-slate-900/
50 backdrop-blur-sm flex items-center justify-center z-50 invisible opacity-0 pointer-events-none transition-all duration-300 ease-out">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 relative mx-4">
        <h2 class="text-lg font-bold text-gray-800 mb-4">Confirmar Eliminación</h2>
        <p class="text-sm text-gray-600 mb-6">¿Estás seguro de que deseas eliminar esta área? Esta acción no se puede
            deshacer.</p>
        <div class="flex justify-end gap-3">
            <button onclick="cerrarModal('modalConfirmacion')"
                class="px-4 py-2.5 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-semibold border border-gray-200/50 transition-all duration-200 cursor-pointer">Cancelar</button>
            <form id="formEliminarArea" method="POST" action="<?= BASE_URL ?>/areas/delete">
                <input type="hidden" name="idArea" id="idAreaEliminar">
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-red-600 text-white hover:bg-red-700 text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200 cursor-pointer">Eliminar</button>
            </form>
        </div>
    </div>
</div>



<script src="<?= BASE_URL ?>/assets/js/area.js"></script>
<?php include __DIR__ . '/../inc/Footer.php'; ?>