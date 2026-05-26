// Función para abrir el modal y prepararlo
function abrirModalLicencias(idEquipo) {
    const modal = document.getElementById('modalGestionLicencias');
    const inputIdPc = document.getElementById('inputAsignarIdPC');
    const contenedorLista = document.getElementById('listaLicenciasVinculadas');

    // 1. Mostramos el modal quitando la clase 'hidden'
    modal.classList.remove('hidden');

    // 2. Le pasamos el ID de la PC al input oculto del formulario
    // para que sepa a qué equipo asignarle la nueva licencia
    inputIdPc.value = idEquipo;

    // 3. Ponemos un mensaje visual de carga mientras trae los datos
    contenedorLista.innerHTML = '<div class="text-sm text-gray-500 text-center py-4">Cargando licencias vinculadas...</div>';

    /* ========================================================================
    🔥 AQUÍ ES DONDE LLENAS LA LISTA DINÁMICAMENTE
    ========================================================================
    Justo aquí vas a hacer tu petición a PHP usando fetch():
    fetch(`tu_ruta_php/obtener_licencias.php?idComputadora=${idEquipo}`)

    Una vez que tu PHP te responda con el JSON, haces un forEach,
    armas el HTML de las tarjetitas blancas y las inyectas dentro de
    "contenedorLista.innerHTML = ...".
    ========================================================================
    */
}

// Función para cerrar el modal
function cerrarModalGestion() {
    const modal = document.getElementById('modalGestionLicencias');

    // 1. Ocultamos el modal agregando 'hidden'
    modal.classList.add('hidden');

    // 2. Reseteamos el formulario de arriba para que quede limpio
    // la próxima vez que abran otra pc
    document.getElementById('formVincularLicencia').reset();
}

function confirmarEliminacion(idComputadora) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Se eliminará esta PC del inventario y no podrás revertirlo.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444', // Rojo Tailwind
        cancelButtonColor: '#9ca3af', // Gris Tailwind
        confirmButtonText: 'Sí, eliminar equipo',
        cancelButtonText: 'Cancelar',
        // Esto le da un borde redondeado bonito tipo Tailwind
        customClass: {
            popup: 'rounded-2xl'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Si dijo que sí, enviamos el formulario específico de este ID
            document.getElementById('formEliminar_' + idComputadora).submit();
        }
    });
}
