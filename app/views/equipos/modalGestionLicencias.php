<div id="modalGestionLicencias" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs transition-all duration-300">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-xl w-full max-w-2xl max-h-[90vh] overflow-hidden flex flex-col transform transition-all">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-[#2CA1C8]/10 rounded-lg text-[#2CA1C8]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-[#0C3B4C]">Licencias del Equipo</h3>
                    <p class="text-xs text-gray-400">Gestiona el software asignado a esta PC</p>
                </div>
            </div>
            <button onclick="cerrarModalGestion()" class="text-gray-400 hover:text-gray-600 p-1.5 hover:bg-gray-100 rounded-xl transition-all cursor-pointer">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-6 bg-white border-b border-gray-100 shadow-sm z-10 relative">
            <form id="formVincularLicencia" action="<?= BASE_URL ?>/equipos/area/asignar" method="post" class="flex flex-col gap-4">
                <input type="hidden" name="idComputadora" id="inputAsignarIdPC" value="">
                <input type="hidden" name="idArea" value="<?= $infoArea['idArea'] ?>">

                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">
                        Licencias Disponibles para Vincular
                    </label>

                    <div class="border border-gray-200 rounded-xl bg-white max-h-[30vh] overflow-y-auto scroll-elegante">
                        <table id="tablaModalLicenciasDisponibles" class="w-full text-left text-sm text-gray-700">
                            <thead class="bg-gray-50 text-xs text-gray-500 uppercase sticky top-0 z-10 border-b border-gray-200">
                            <tr>
                                <th class="px-4 py-3 w-10 text-center">✓</th>
                                <th class="px-4 py-3">Software</th>
                                <th class="px-4 py-3">Código</th>
                                <th class="pl-4 pr-8 py-3 text-center">Uso</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                            <?php if (!empty($licencias)): ?>
                                <?php foreach ($licencias as $licencia): ?>
                                    <tr class="hover:bg-gray-50 transition-colors cursor-pointer" onclick="document.getElementById('check_<?= $licencia['idLicencia'] ?>').click()">
                                        <td class="pl-4 pr-8 py-3 text-center" onclick="event.stopPropagation()">
                                            <input type="checkbox" id="check_<?= $licencia['idLicencia'] ?>" name="idLicencias[]" value="<?= $licencia['idLicencia'] ?>" class="w-4 h-4 text-[#2CA1C8] bg-gray-100 border-gray-300 rounded focus:ring-[#2CA1C8] cursor-pointer">
                                        </td>
                                        <td class="px-4 py-3 font-medium text-gray-900">
                                            <?= $licencia["nombreTipoLicencia"] ?>
                                        </td>
                                        <td class="px-4 py-3 font-mono text-xs text-gray-500">
                                            <?= $licencia["codigoLicencia"] ?>
                                        </td>
                                        <td class="px-4 py-3 text-center">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-200">
                                            <?= $licencia["totalAsignados"] ?> / <?= $licencia["numPermitVinculados"] ?? '∞' ?>
                                        </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-4 py-8 text-center text-gray-400 text-sm">
                                        No hay licencias disponibles en este momento.
                                    </td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="w-full sm:w-auto bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-6 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-md flex justify-center items-center gap-2 cursor-pointer <?php echo empty($licencias) ? 'opacity-50 cursor-not-allowed' : ''; ?>" <?php echo empty($licencias) ? 'disabled' : ''; ?>>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Asignar Seleccionadas
                    </button>
                </div>
            </form>
        </div>

        <div class="p-6 bg-gray-50/50 flex-1 overflow-hidden flex flex-col">
            <h4 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-3">Software Instalado</h4>

            <div id="listaLicenciasVinculadas" class="overflow-y-auto pr-3 flex flex-col gap-3 max-h-[35vh] scroll-elegante">

            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const BASE_URL_JS = '<?= BASE_URL ?>'; // O BASE_URL, la que tengas definida
</script>
<script src="<?=BASE_URL?>/assets/js/equipos.js"></script>