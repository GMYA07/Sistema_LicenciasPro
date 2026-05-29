// Función para abrir el modal y prepararlo
async function abrirModalLicencias(idEquipo) {
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

    try{
        //await ayuda a q el codigo espere a la respuesta de php
        const respuesta = await fetch(`${BASE_URL_JS}/equipos/area/obtener_licencias?idComputadora=${idEquipo}`);

        //Convertimos la respuesta del server a json
        const licencias = await respuesta.json();

        contenedorLista.innerHTML = ''; //Limpiamos para quitar el mensaje de cargando licencias

        //Si la pc no tiene nada solo le mandamos ese mensaje
        if (licencias.length === 0) {
            contenedorLista.innerHTML = '<div class="text-sm text-gray-500 text-center py-4">Este equipo no tiene software asignado.</div>';
            return;
        }

        //Si hay licencias lo recorreremos con un foreach
        licencias.forEach(licencia => {

            // --- LÓGICA DEL BADGE ---
            // Por defecto lo ponemos Verde
            let clasesBadge = 'bg-emerald-50 text-emerald-600 border-emerald-200';

            // Si dice Expirada, lo pasamos a Amarillo (Ámbar en Tailwind)
            if (licencia.estadoLicencia === 'Expirada') {
                clasesBadge = 'bg-amber-50 text-amber-600 border-amber-200';
            }

            // Usamos las "backticks" (`) para escribir HTML multilínea e inyectar variables con ${}
            const tarjetaHTML = `
                <div class="bg-white border border-gray-200 rounded-xl p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm hover:border-[#2CA1C8]/30 transition-colors">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <h4 class="text-sm font-bold text-gray-800">${licencia.nombreTipoLicencia}</h4>
                            <span class="text-[10px] px-2 py-0.5 rounded-full font-bold border ${clasesBadge}">
                                ${licencia.estadoLicencia}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 font-mono bg-gray-50 inline-block px-2 py-1 rounded border border-gray-100 mt-1">
                            ${licencia.codigoLicencia}
                        </p>
                    </div>
                    
                    <button type="button" onclick="desvincularLicencia(${licencia.idLicencia},${idEquipo})" title="Desvincular" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
            `;

            // Agregamos la tarjeta al contenedor
            contenedorLista.innerHTML += tarjetaHTML;
        });

    }catch (error){
        //Con esto mostrara el error en la consola del nav
        console.error("Error al traer los datos:", error);
        contenedorLista.innerHTML = '<div class="text-sm text-red-500 text-center py-4">Hubo un error al cargar las licencias.</div>';
    }

}

async function desvincularLicencia(idLicencia,idEquipo) {
    //Se pregunta si encerio quiere hacerlo
    const confirmar = await Swal.fire({
        title: '¿Desvincular licencia?',
        text: "La licencia quedará disponible para otros equipos.",
        icon: 'text',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#9ca3af',
        confirmButtonText: 'Sí, desvincular',
        cancelButtonText: 'Cancelar',
        customClass: { popup: 'rounded-2xl' }
    });

    if (!confirmar.isConfirmed) return; //si el usuario cancelo, no hacemos nada

    try{
        //Preparamos los datos para simular un form invisible y enviar la solicitud al servidor
        const datos = new FormData();
        datos.append('idLicencia', idLicencia);
        datos.append('idComputadora', idEquipo);

        //Hacemos el metodo fetch para la peticion
        const respuesta = await fetch(`${BASE_URL_JS}/equipos/area/desvincular_licencia`, {
            method: 'POST',
            body: datos // Le mandamos los IDs al PHP
        });

        const resultado = await respuesta.json();

        if (resultado.status === 'success') {
            Swal.fire({
                title: '¡Desvinculada!',
                text: resultado.message,
                icon: 'success',
                timer: 1500,
                showConfirmButton: false,
                customClass: { popup: 'rounded-2xl' }
            });

            // Volvemos a llamar a la función que ya hiciste para que limpie
            abrirModalLicencias(idEquipo);
        } else {
            Swal.fire('Error', resultado.message, 'error');
        }


    }catch (error) {
        console.error("Error al desvincular:", error);
        Swal.fire('Error', 'No se pudo procesar la solicitud', 'error');
    }

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
