<?php include __DIR__ . '/../inc/Header.php'; ?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-12">

    <div class="flex items-center gap-4">
        <div class="p-3 bg-[#2CA1C8]/10 rounded-2xl text-[#2CA1C8]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>

        <div>
            <h1 class="text-2xl font-bold text-[#0C3B4C]">Editar Equipo</h1>
            <p class="text-sm text-gray-500 font-medium mt-1">Edicion de equipos</p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <a href="<?= BASE_URL ?>/equipos/area?idArea=<?= $computadora['idAreaComputadora']; ?>" class="flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-600 border border-gray-200 px-5 py-2.5 rounded-xl font-medium text-sm shadow-sm transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a Áreas
        </a>
    </div>

</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm w-full max-w-3xl mx-auto overflow-hidden flex flex-col mt-6">

    <form action="<?= BASE_URL ?>/equipos/area/edit" method="POST" class="p-8 flex flex-col gap-6">
        <input type="hidden" name="idComputadora" value="<?= $computadora['idComputadora']; ?>">
        <div>
            <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Área / Ubicación</label>
            <div class="relative">
                <select name="idAreaComputadora" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:border-[#2CA1C8] focus:ring-1 focus:ring-[#2CA1C8] focus:bg-white transition-all appearance-none">
                    <?php foreach($areas as $area): ?>
                        <option value="<?= $area['idArea']; ?>" <?= ($area['idArea'] == $computadora['idAreaComputadora']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($area['nombreArea']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Marca</label>
                <div class="relative">
                    <select name="Marca" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:border-[#2CA1C8] focus:ring-1 focus:ring-[#2CA1C8] focus:bg-white transition-all appearance-none">
                        <option value="Dell" <?= ($computadora['Marca'] == 'Dell') ? 'selected' : '' ?>>
                            Dell
                        </option>
                        <option value="Lenovo" <?= ($computadora['Marca'] == 'Lenovo') ? 'selected' : '' ?>>
                            Lenovo
                        </option>
                        <option value="HP" <?= ($computadora['Marca'] == 'HP') ? 'selected' : '' ?>>
                            HP
                        </option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Modelo</label>
                <input type="text" name="Modelo" value="<?= $computadora['Modelo']?>" required placeholder="Ej: OptiPlex 3080" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-[#2CA1C8] focus:ring-1 focus:ring-[#2CA1C8] focus:bg-white transition-all">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Número de Serie (Serial)</label>
                <input type="text" name="Serial" value="<?= $computadora['Serial']?>" required placeholder="Ej: SN-987654321" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-mono focus:outline-none focus:border-[#2CA1C8] focus:ring-1 focus:ring-[#2CA1C8] focus:bg-white transition-all">
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Estado Inicial</label>
                <div class="relative">
                    <select name="estadoComputadora" required class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm text-gray-700 focus:outline-none focus:border-[#2CA1C8] focus:ring-1 focus:ring-[#2CA1C8] focus:bg-white transition-all appearance-none">
                        <option value="activa" <?= ($computadora['estadoComputadora'] == 'activa') ? 'selected' : '' ?>>
                            Activa
                        </option>
                        <option value="mantenimiento" <?= ($computadora['estadoComputadora'] == 'mantenimiento') ? 'selected' : '' ?>>
                            En Mantenimiento
                        </option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 mt-4 pt-6 border-t border-gray-100">
            <button type="submit" class="flex items-center gap-2 bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-6 py-2.5 rounded-xl font-semibold text-sm shadow-md transition-all cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                Editar Equipo
            </button>
        </div>

    </form>
</div>


<?php include __DIR__ . '/../inc/Footer.php'; ?>
