<div id="modalLicenciasEquipo" class="fixed inset-0 z-50 hidden flex items-center justify-center p-4 bg-black/40 backdrop-blur-xs transition-all duration-300">
    <div class="bg-white rounded-2xl border border-gray-200 shadow-xl w-full max-w-2xl overflow-hidden flex flex-col transform transition-all">

        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-[#2CA1C8]/10 rounded-lg text-[#2CA1C8]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-[#0C3B4C]">Licencias del Equipo</h3>
                    <p class="text-xs text-gray-400">Software actualmente instalado o asignado a esta PC</p>
                </div>
            </div>
            <button onclick="cerrarModalLicencias()" class="text-gray-400 hover:text-gray-600 p-1.5 hover:bg-gray-100 rounded-xl transition-all cursor-pointer">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <div class="p-6 bg-gray-50/50">

            <div id="listaLicenciasVinculadas" class="max-h-[60vh] overflow-y-auto pr-2 flex flex-col gap-3">

                <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm hover:border-[#2CA1C8]/30 transition-colors">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="text-sm font-bold text-gray-800">Windows 11 Pro</h4>
                            <span class="text-[10px] px-2 py-0.5 rounded-full font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">Vigente</span>
                        </div>
                        <p class="text-xs text-gray-500 font-mono bg-gray-50 inline-block px-2 py-1 rounded border border-gray-100 mt-1">
                            W269N-WFGWX-YVC9B-4J6C9-T83GX
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button title="Remover de este equipo" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" /> </svg>
                        </button>
                    </div>
                </div>

                <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm hover:border-[#2CA1C8]/30 transition-colors">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="text-sm font-bold text-gray-800">Adobe Photoshop CC</h4>
                            <span class="text-[10px] px-2 py-0.5 rounded-full font-bold bg-amber-50 text-amber-600 border border-amber-200">Por Vencer</span>
                        </div>
                        <p class="text-xs text-gray-500 font-mono bg-gray-50 inline-block px-2 py-1 rounded border border-gray-100 mt-1">
                            1045-1209-6738-4668-7696-2783
                        </p>
                    </div>

                    <div class="flex items-center gap-2">
                        <button title="Remover de este equipo" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

            <button class="mt-4 w-full border-2 border-dashed border-gray-300 rounded-xl p-4 text-gray-500 hover:text-[#2CA1C8] hover:border-[#2CA1C8] hover:bg-[#2CA1C8]/5 transition-all font-semibold text-sm flex items-center justify-center gap-2 cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Vincular nueva licencia
            </button>

        </div>

        <div class="px-6 py-4 bg-white flex justify-end border-t border-gray-100">
            <button type="button" onclick="cerrarModalLicencias()" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all cursor-pointer">
                Cerrar
            </button>
        </div>
    </div>
</div>