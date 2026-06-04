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
        <?php
        // 1. Validamos si está activa
        $activa = ($area['estadoCentroComputo'] == 1);
        ?>

        <a href="<?= $activa ? BASE_URL . '/equipos/area?idArea=' . $area['idArea'] : '#' ?>"
           class="rounded-2xl p-6 border shadow-sm relative overflow-hidden flex flex-col min-h-[160px] transition-all duration-300 group
              <?= $activa ? 'bg-white border-gray-100 hover:shadow-lg hover:-translate-y-1' : 'bg-gray-50 border-gray-200 opacity-70 cursor-not-allowed pointer-events-none grayscale-[20%]' ?>">

            <div class="absolute top-0 left-0 w-full h-1 transition-opacity
                    <?= $activa ? 'bg-[#2CA1C8] opacity-0 group-hover:opacity-100' : 'bg-gray-400 opacity-100' ?>"></div>

            <div class="mb-4 flex justify-between items-start">
                <div class="inline-block p-3 rounded-xl transition-colors
                        <?= $activa ? 'bg-[#2CA1C8]/10 text-[#2CA1C8] group-hover:bg-[#2CA1C8] group-hover:text-white' : 'bg-gray-200 text-gray-400' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                    </svg>
                </div>

                <?php if(!$activa): ?>
                    <span class="px-2.5 py-1 text-[10px] font-bold uppercase tracking-wider text-gray-500 bg-gray-200 border border-gray-300 rounded-full">
                        Inactiva
                    </span>
                <?php endif; ?>
            </div>

            <div class="flex-1">
                <h3 class="text-xl font-bold mb-1 transition-colors
                       <?= $activa ? 'text-[#0C3B4C] group-hover:text-[#2CA1C8]' : 'text-gray-500' ?>">
                    <?= $area['nombreArea'] ?>
                </h3>
                <p class="text-sm text-gray-400">Edificio <?= $area['edificio'] ?></p>
            </div>

            <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-4">
                <div class="flex items-center gap-2 transition-colors <?= $activa ? 'text-gray-500 group-hover:text-gray-700' : 'text-gray-400' ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 <?= $activa ? 'text-[#2CA1C8]' : 'text-gray-400' ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm font-semibold"><?= $area['totalComputadoras'] ?>/<?= $area['numEquipos'] ?> Equipos</span>
                </div>

                <?php if($activa): ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 group-hover:text-[#2CA1C8] group-hover:translate-x-1 transition-all" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                <?php endif; ?>
            </div>
        </a>

    <?php endforeach; ?>



</div>

<?php include __DIR__ . '/../inc/Footer.php'; ?>
