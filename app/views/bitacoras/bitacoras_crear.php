<?php include __DIR__ . '/../inc/Header.php'; ?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-12">

    <div class="flex items-center gap-4">
        <div class="p-3 bg-[#2CA1C8]/10 rounded-2xl text-[#2CA1C8]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>

        <div>
            <h1 class="text-2xl font-bold text-[#0C3B4C]">Nueva Bitacora</h1>
            <p class="text-sm text-gray-500 font-medium mt-1">Creacion de nuevas bitacoras</p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <a href="<?= BASE_URL ?>/bitacoras" class="flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-600 border border-gray-200 px-5 py-2.5 rounded-xl font-medium text-sm shadow-sm transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a Bitacoras
        </a>
    </div>

</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm w-full max-w-3xl mx-auto overflow-hidden flex flex-col mt-6">

    <form action="<?= BASE_URL ?>/bitacoras/create" method="POST" id="formBitacora" class="p-8 flex flex-col gap-6">

        <input type="hidden" name="idUsuario" value="<?= $_SESSION['usuario_id'] ?? 1 ?>">

        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Área a Inspeccionar</label>
            <div class="relative">
                <select name="idArea" id="selectArea" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:border-[#2CA1C8] focus:ring-1 focus:ring-[#2CA1C8] focus:bg-white transition-all appearance-none">
                    <option value="" disabled selected>-- Seleccione un área --</option>
                    <?php foreach ($areas as $area): ?>
                        <?php if ($area['estadoCentroComputo'] == 1): ?>
                            <option value="<?= $area['idArea'] ?>"><?= $area['nombreArea'] ?> (<?= $area['edificio'] ?>)</option>
                        <?php endif;?>
                    <?php endforeach; ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
            <div>
                <label class="block text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1 text-center">Total Equipos</label>
                <input type="number" name="totalEquipos" id="totalEquipos" readonly value="0"
                       class="w-full bg-gray-200/50 border-none rounded-lg px-4 py-3 text-xl font-bold text-gray-600 text-center focus:outline-none cursor-not-allowed">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-[#2CA1C8] uppercase tracking-wider mb-1 text-center">Con Licencia</label>
                <input type="number" name="equiposConLicencia" id="equiposConLicencia" readonly value="0"
                       class="w-full bg-[#2CA1C8]/10 border-none rounded-lg px-4 py-3 text-xl font-bold text-[#2CA1C8] text-center focus:outline-none cursor-not-allowed">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-[#2CA1C8] uppercase tracking-wider mb-1 text-center">Sin Licencia</label>
                <input type="number" name="equiposSinLicencia" id="equiposSinLicencia" readonly value="0"
                       class="w-full bg-[#2CA1C8]/10 border-none rounded-lg px-4 py-3 text-xl font-bold text-[#2CA1C8] text-center focus:outline-none cursor-not-allowed">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Observaciones del Técnico</label>
            <textarea name="observaciones" rows="4" placeholder="Ej: Se encontraron 2 máquinas sin licencia, actualmente están en mantenimiento..."
                      class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#2CA1C8] focus:ring-1 focus:ring-[#2CA1C8] focus:bg-white transition-all resize-none"></textarea>
        </div>

        <div class="flex items-center justify-end gap-4 mt-2 pt-6 border-t border-gray-100">
            <button type="submit" class="flex items-center gap-2 bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-6 py-2.5 rounded-xl font-semibold text-sm shadow-md transition-all cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Generar Bitacora
            </button>
        </div>

    </form>
</div>

<script>
    const BASE_URL_JS = '<?= BASE_URL ?>'; // O BASE_URL, la que tengas definida
</script>
<script src="<?=BASE_URL?>/assets/js/bitacoras.js"></script>

<?php include __DIR__ . '/../inc/Footer.php'; ?>
