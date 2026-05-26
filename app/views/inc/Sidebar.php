<aside
    class="w-64 bg-[#0C3B4C] text-[#E6E6E6] flex flex-col justify-between shadow-xl transition-all duration-300 h-screen">

    <div>
        <div class="flex flex-col items-center pt-6 pb-2 border-b border-[#1E85A8]/50">
            <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Logotipo" class="h-24 w-auto mb-2" />
        </div>

        <nav class="mt-4 px-4 space-y-4">

            <a href="<?= BASE_URL ?>/home"
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-[#E6E6E6] hover:bg-[#1E85A8] hover:text-white transition-all group">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 text-[#2CA1C8] group-hover:text-white transition-colors" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z" />
                </svg>
                Dashboard
            </a>

            <div>
                <p class="px-4 text-xs font-semibold text-[#2CA1C8] uppercase tracking-wider mb-2">Inventario</p>
                <a href="<?= BASE_URL ?>/equipos"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-[#E6E6E6] hover:bg-[#1E85A8] hover:text-white transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-[#2CA1C8] group-hover:text-white transition-colors" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Equipos
                </a>
            </div>

            <div>
                <p class="px-4 text-xs font-semibold text-[#2CA1C8] uppercase tracking-wider mb-2">Software</p>

                <a href="<?= BASE_URL ?>/areas"
                    class="flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl text-[#E6E6E6] hover:bg-[#1E85A8] hover:text-white transition-all group">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-[#2CA1C8] group-hover:text-white transition-colors" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        Areas
                    </div>
                </a>

                <a href="<?= BASE_URL ?>/licencias"
                    class="flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl text-[#E6E6E6] hover:bg-[#1E85A8] hover:text-white transition-all group">
                    <div class="flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 text-[#2CA1C8] group-hover:text-white transition-colors" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                        </svg>
                        Licencias
                    </div>
                </a>
            </div>
        </nav>
    </div>

    <div class="p-4 border-t border-[#1E85A8]/50">
        <a href="<?= BASE_URL ?>/logout"
            class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-xl text-[#E6E6E6] hover:text-white hover:bg-rose-600 transition-all duration-300 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:-translate-x-1 transition-transform"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
            </svg>
            <span class="text-sm font-semibold">Salir, <?= $_SESSION['usuario_nombre'] ?></span>
        </a>
    </div>

</aside>