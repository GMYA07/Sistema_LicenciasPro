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
            <!-- BOTÓN MODIFICADO PARA ABRIR EL MODAL PRINCIPAL -->
            <button onclick="abrirModal('modalLicencia')" class="flex items-center gap-2 bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-300 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Nueva Licencia
            </button>
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

                    <!-- Fila de ejemplo estática -->
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

    <!-- ========================================== -->
    <!-- MODAL 1: AGREGAR NUEVA LICENCIA            -->
    <!-- ========================================== -->
    <div id="modalLicencia" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs transition-all duration-300">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-xl w-full max-w-lg overflow-hidden flex flex-col transform transition-all">
            
            <!-- Header Modal -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white">
                <div>
                    <h3 class="text-lg font-bold text-[#0C3B4C]">Registrar Nueva Licencia</h3>
                    <p class="text-xs text-gray-400">Llena los datos para añadir un software al inventario</p>
                </div>
                <button onclick="cerrarModal('modalLicencia')" class="text-gray-400 hover:text-gray-600 p-1.5 hover:bg-gray-100 rounded-xl transition-all">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Formulario -->
            <form id="formNuevaLicencia" class="p-6 flex flex-col gap-4">
                
                <!-- Select de Tipo Licencia con Botón Integrado -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Tipo de Licencia</label>
                    <div class="flex gap-2">
                        <div class="relative flex-1">
                            <select name="idTipoLicencia" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#2CA1C8] focus:bg-white transition-all appearance-none">
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
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                        <!-- Botón para abrir el segundo modal -->
                        <button type="button" onclick="abrirSubModal()" class="bg-[#2CA1C8]/10 hover:bg-[#2CA1C8]/20 text-[#2CA1C8] px-3.5 rounded-xl font-medium text-sm transition-all flex items-center justify-center gap-1 cursor-pointer" title="Gestionar Tipos">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Código de Licencia -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Código / Clave de Licencia</label>
                    <input type="text" name="codigoLicencia" required placeholder="Ej: XXXXX-XXXXX-XXXXX-XXXXX" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-mono focus:outline-none focus:border-[#2CA1C8] focus:bg-white transition-all">
                </div>

                <!-- Estado Licencia (ENUM) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Estado Inicial</label>
                    <div class="relative">
                        <select name="estadoLicencia" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-700 focus:outline-none focus:border-[#2CA1C8] focus:bg-white transition-all appearance-none">
                            <option value="No instalada" selected>No instalada (Disponible)</option>
                            <option value="Vigente">Vigente (Activa)</option>
                            <option value="Expirada">Expirada</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Botones Acciones -->
                <div class="flex items-center justify-end gap-3 mt-4 pt-4 border-t border-gray-100">
                    <button type="button" onclick="cerrarModal('modalLicencia')" class="px-4 py-2.5 text-sm font-semibold text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-xl transition-all cursor-pointer">
                        Cancelar
                    </button>
                    <button type="submit" class="bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md transition-all cursor-pointer">
                        Guardar Licencia
                    </button>
                </div>
            </form>
        </div>
    </div>


    <!-- ========================================== -->
    <!-- MODAL 2: GESTIONAR TIPOS DE LICENCIAS       -->
    <!-- ========================================== -->
    <div id="modalTipoLicencia" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs transition-all duration-300">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-xl w-full max-w-xl overflow-hidden flex flex-col transform transition-all">
            
            <!-- Header Modal -->
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white">
                <div>
                    <h3 class="text-lg font-bold text-[#0C3B4C]">Gestionar Tipos de Licencias</h3>
                    <p class="text-xs text-gray-400">Agrega, edita o remueve las categorías de software</p>
                </div>
                <button onclick="cerrarSubModal()" class="text-gray-400 hover:text-gray-600 p-1.5 hover:bg-gray-100 rounded-xl transition-all">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-6 flex flex-col gap-6">
                <!-- Mini Formulario -->
                <form id="formNuevoTipo" class="bg-gray-50 border border-gray-100 p-4 rounded-xl flex flex-col sm:flex-row gap-3 items-end">
                    <input type="hidden" id="idTipoLicencia" name="idTipoLicencia" value="">

                        <div class="flex-1 w-full">
                            <label id="labelFormTipo" class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                                Nuevo Tipo de Licencia
                            </label>
                            <input type="text" id="nombreTipoLicencia" name="nombreTipoLicencia" required placeholder="Ej: Diseño Gráfico" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-2 text-sm focus:outline-none focus:border-[#2CA1C8] transition-all">
                        </div>

                        <div class="flex gap-2 w-full sm:w-auto">
                            <button type="button" id="btnCancelarEdicion" onclick="limpiarFormularioTipo()" class="hidden bg-gray-300 text-gray-700 px-3 py-2 rounded-xl font-semibold text-sm h-[38px] cursor-pointer">
                                Cancelar
                            </button>
                            <button type="submit" id="btnSubmitTipo" class="w-full sm:w-auto bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-4 py-2 rounded-xl font-semibold text-sm transition-all h-[38px] cursor-pointer">
                                Añadir
                            </button>
                        </div>
                </form>

                <!-- Tabla de Tipos Existentes -->
                <div class="flex flex-col">
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Categorías Registradas</label>
                    <div class="border border-gray-200 rounded-xl overflow-hidden max-h-52 overflow-y-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <tbody class="bg-white divide-y divide-gray-100">
                               <?php if (!empty($tipodeLicencias)): ?>
                                    <?php foreach ($tipodeLicencias as $tipo): ?>
                                        <tr>
                                            <td class="px-4 py-2.5 text-gray-700 font-medium">
                                                <?php echo htmlspecialchars($tipo['nombreTipoLicencia']); ?>
                                            </td>
                                            <td class="px-4 py-2.5 text-right whitespace-nowrap">
                                                <!-- Pasamos el ID real de la base de datos a las funciones de JS -->
                                                <button type="button" onclick='editarTipo(<?php echo (int)$tipo["idTipoLicencia"]; ?>, <?php echo json_encode($tipo["nombreTipoLicencia"], JSON_HEX_APOS | JSON_HEX_QUOT); ?>)' class="text-xs font-semibold hover:underline mr-3" style="color:#2CA1C8;">
                                                    Editar
                                                </button>
                                                <button type="button" onclick="confirmEliminar(<?php echo (int)$tipo['idTipoLicencia']; ?>)" class="text-xs font-semibold text-red-600 hover:underline bg-transparent border-0 p-0">
                                                    Eliminar
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
                <button type="button" onclick="cerrarSubModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-xl font-semibold text-xs transition-all cursor-pointer">
                    Regresar a Licencia
                </button>
            </div>
        </div>
    </div>

<script src="<?= BASE_URL ?>/assets/js/licencias.js?v=<?= time() ?>"></script>

<?php include __DIR__ . '/../inc/Footer.php'; ?>