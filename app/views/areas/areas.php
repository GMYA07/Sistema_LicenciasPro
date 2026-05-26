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

                        <input id="buscarArea" type="text" placeholder="Buscar área..."
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 placeholder:text-gray-400 text-sm rounded-xl pl-10 pr-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">
                    </div>

                    <!-- Filtro -->
                    <div
                        class="flex items-center gap-2 bg-gray-50 border border-gray-200 rounded-xl px-3 py-1.5 w-full sm:w-auto">
                        <select id="filtro-estado"
                            class="bg-transparent text-sm text-gray-700 focus:outline-none cursor-pointer w-full">
                            <option value="">Todos</option>
                            <option value="centro">Centro de Cómputo</option>
                            <option value="oficina">Oficina/Aula Común</option>
                        </select>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>


<div class="bg-white rounded-2xl mt-4 border border-gray-200 shadow-sm overflow-hidden flex-1 flex flex-col">
    <!-- Tabla Responsive -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 align-middle">
            <thead>
                <tr class="bg-gray-50/75 border-b border-gray-200">
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Nombre del Área
                    </th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Ubicación (Edificio)
                    </th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Número de Equipos
                    </th>
                    <th scope="col" class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">
                        Centro de Cómputo
                    </th>
                    <th scope="col" class="px-6 py-3.5 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">
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
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono font-medium bg-gray-100 text-gray-700 border border-gray-200">
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
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-200/50">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-green-500"></span>
                                        Activo
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                        <span class="w-1.5 h-1.5 mr-1.5 rounded-full bg-gray-400"></span>
                                        Inactivo
                                    </span>
                                <?php endif; ?>
                            </td>

                            <!-- Acciones -->
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex items-center justify-center gap-2">
                                    <button onclick="abrirModal('modalArea', <?= $area['idArea'] ?>)"
                                        class="inline-flex items-center text-blue-600 hover:text-blue-900 px-3 py-1.5 rounded-lg bg-blue-50/50 hover:bg-blue-100 border border-blue-200/20 transition-all duration-200">
                                        Editar
                                    </button>
                                    <button onclick="confirmarEliminarArea(<?= $area['idArea'] ?>)"
                                        class="inline-flex items-center text-red-600 hover:text-red-900 px-3 py-1.5 rounded-lg bg-red-50/50 hover:bg-red-100 border border-red-200/20 transition-all duration-200">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- Estado de Tabla Vacía -->
                    <tr>
                        <td colspan="5" class="px-6 py-12 whitespace-nowrap text-sm text-gray-400 text-center">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                <span>No hay áreas registradas en el sistema.</span>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>
        </table>
    </div>
</div>

<!-- modal princiapal para agragar y editar ares -->
<div id="modalArea" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
        <button onclick="cerrarModal('modalArea')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <h2 id="modalTitleArea" class="text-xl font-bold text-gray-800 mb-4">Agregar Nueva Área</h2>
        <form id="formArea" method="POST" action="<?= BASE_URL ?>/areas/guardar">
            <input type="hidden" name="idArea" id="idArea">
            <div class="mb-4">
                <label for="nombreArea" class="block text-sm font-medium text-gray-700 mb-1">Nombre del Área</label>
                <input type="text" name="nombreArea" id="nombreArea" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">
            </div>
            <div class="mb-4">
                <label for="edificio" class="block text-sm font-medium text-gray-700 mb-1">Ubicación (Edificio)</label>
                <input type="text" name="edificio" id="edificio" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">
            </div>
            <div class="mb-4">
                <label for="numEquipos" class="block text-sm font-medium text-gray-700 mb-1">Número de Equipos</label>
                <input type="number" name="numEquipos" id="numEquipos" required min="0"
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition"> 
            </div>
            <div class="mb-4">
                <label for="estadoCentroComputo" class="block text-sm font-medium text-gray-700 mb-1">Centro de Cómputo</label>
                <select name="estadoCentroComputo" id="estadoCentroComputo" required
                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 transition">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="flex justify-end gap-3">
                <button type="button" onclick="cerrarModal('modalArea')"
                    class="px-4 py-2 rounded-lg bg-gray-100 text-gray-700 hover:bg-gray-200 transition-all duration-200">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-4 py-2 rounded-lg bg-[#2CA1C8] text-white hover:bg-[#1E85A8] transition-all duration-200">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>


<script src="<?= BASE_URL ?>/assets/js/area.js"></script>
<?php include __DIR__ . '/../inc/Footer.php'; ?>