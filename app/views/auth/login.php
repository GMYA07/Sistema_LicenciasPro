<?php include __DIR__ . '/../inc/Header.php'; ?>

    <div class="h-full bg-[#F4F8FA] flex items-center justify-center p-4 font-sans w-full">

        <div class="max-w-md w-full bg-white rounded-2xl shadow-2xl overflow-hidden">

            <div class="bg-[#0C3B4C] p-8 text-center flex flex-col items-center border-b-4 border-[#2CA1C8]">
                <img src="<?= BASE_URL ?>/assets/img/logo.png" alt="Logotipo UNICAES" class="h-24 w-auto mb-4" />
                <h2 class="text-2xl font-bold text-white tracking-wide">Licencias Pro</h2>
                <p class="text-[#2CA1C8] text-sm mt-1 font-medium">Sistema de Gestión de Licencias</p>
            </div>

            <div class="p-8">
                <form action="#" method="POST" class="space-y-6">

                    <div>
                        <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">Usuario</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <input type="text" id="username" name="username" required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2CA1C8] focus:border-transparent transition-all"
                                   placeholder="admin_licencias">
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Contraseña</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl text-gray-800 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#2CA1C8] focus:border-transparent transition-all"
                                   placeholder="••••••••">
                        </div>
                    </div>

                    <button type="submit"
                            class="w-full bg-[#2CA1C8] hover:bg-[#1E85A8] text-white font-bold py-3 px-4 rounded-xl shadow-md hover:shadow-lg transition-all duration-300 flex justify-center items-center gap-2 group">
                        <span>Iniciar Sesión</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

<?php include __DIR__ . '/../inc/Footer.php'; ?>