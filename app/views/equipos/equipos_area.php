<?php include __DIR__ . '/../inc/Header.php'; ?>

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-12">

    <div class="flex items-center gap-4">
        <div class="p-3 bg-[#2CA1C8]/10 rounded-2xl text-[#2CA1C8]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>

        <div>
            <h1 class="text-2xl font-bold text-[#0C3B4C]">Gestión de Equipos - <?= $infoArea['nombreArea'] ?></h1>
            <p class="text-sm text-gray-500 font-medium mt-1">Administra el inventario de computadoras.</p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">

        <a href="<?= BASE_URL ?>/equipos" class="flex items-center gap-2 bg-white hover:bg-gray-50 text-gray-600 border border-gray-200 px-5 py-2.5 rounded-xl font-medium text-sm shadow-sm transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Volver a Áreas
        </a>

        <a href="#" class="flex items-center gap-2 bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md hover:shadow-lg transition-all duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Nuevo Equipo
        </a>

    </div>

</div>

<?php include __DIR__ . '/../inc/Footer.php'; ?>
