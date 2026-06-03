<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Licencias Pro</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body class="bg-stone-100 text-stone-800 font-sans h-screen">

<div class="fixed top-6 right-6 z-50 flex flex-col gap-3 pointer-events-none">

    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
        <div id="toast-error" class="flex items-center gap-4 bg-white border-l-4 border-red-500 px-5 py-4 rounded-xl shadow-2xl pointer-events-auto transform transition-all duration-500 translate-x-0 opacity-100 max-w-sm w-full">
            <div class="p-2 bg-red-50 rounded-lg text-red-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            <div class="flex-1">
                <h4 class="text-sm font-bold text-gray-900">¡Ups! Algo salió mal</h4>
                <p class="text-sm text-gray-500 mt-0.5">¡Usuario o contraseña incorrectos!</p>
            </div>
            <button onclick="cerrarToast('toast-error')" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    <?php endif; ?>

</div>

<script>
    function cerrarToast(id) {
        const toast = document.getElementById(id);
        if (toast) {
            // Le agregamos clases para que se deslice a la derecha y se vuelva transparente
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-full', 'opacity-0');
            // Esperamos que termine la animación (500ms) y lo eliminamos del DOM
            setTimeout(() => {
                toast.remove();
            }, 500);
        }
    }
    // Autocerrar después de 4 segundos (4000 milisegundos)
    setTimeout(() => {
        cerrarToast('toast-error');
        cerrarToast('toast-success');
    }, 4000);
</script>