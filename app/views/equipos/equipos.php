<?php include __DIR__ . '/../inc/Header.php'; ?>
<!--Titulo de la vista-->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-12">

    <div class="flex items-center gap-4">
        <div class="p-3 bg-[#2CA1C8]/10 rounded-2xl text-[#2CA1C8]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
        </div>

        <div>
            <h1 class="text-2xl font-bold text-[#0C3B4C]">Gestión de Equipos</h1>
            <p class="text-sm text-gray-500 font-medium mt-1">Administra el inventario de computadoras.</p>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3">
        <!--Para agregar botones si despues aqui seria para administrar areas-->
    </div>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <?php foreach($areas as $area): ?>

        <a href="<?= BASE_URL ?>/equipos/area?idArea=<?= $area['idArea'] ?>" class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group relative overflow-hidden flex flex-col min-h-[160px]">

            <div class="absolute top-0 left-0 w-full h-1 bg-[#2CA1C8] opacity-0 group-hover:opacity-100 transition-opacity"></div>

            <div class="mb-4">
                <div class="inline-block p-3 bg-[#2CA1C8]/10 rounded-xl text-[#2CA1C8] group-hover:bg-[#2CA1C8] group-hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                    </svg>
                </div>
            </div>

            <div class="flex-1">
                <h3 class="text-xl font-bold text-[#0C3B4C] mb-1 group-hover:text-[#2CA1C8] transition-colors">
                    <?= $area['nombreArea'] ?>
                </h3>
                <p class="text-sm text-gray-400">Edificio <?= $area['edificio'] ?></p>
            </div>

            <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-4">
                <div class="flex items-center gap-2 text-gray-500 group-hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#2CA1C8]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm font-semibold">0/<?= $area['numEquipos'] ?> Equipos</span>
                </div>

                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-[#2CA1C8] group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </div>
        </a>

    <?php endforeach; ?>



</div>

<?php include __DIR__ . '/../inc/Footer.php'; ?>
