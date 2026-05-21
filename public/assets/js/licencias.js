
    //     JAVASCRIPT CONTROL DE MODALES         

        // Funciones generales de apertura y cierre
        function abrirModal(idModal) {
            const modal = document.getElementById(idModal);
            modal.classList.remove('hidden');
            // Retraso milimétrico para simular la transición de opacidad suave
            setTimeout(() => {
                modal.classList.add('opacity-100');
            }, 50);
        }

        function cerrarModal(idModal) {
            const modal = document.getElementById(idModal);
            modal.classList.add('hidden');
        }

        // Lógica especial para alternar fluidamente entre Modales superpuestos
        function abrirSubModal() {
            // Ocultamos el primer modal momentáneamente
            document.getElementById('modalLicencia').classList.add('hidden');
            // Mostramos el segundo modal
            abrirModal('modalTipoLicencia');
        }

        function cerrarSubModal() {
            // Ocultamos el modal secundario
            document.getElementById('modalTipoLicencia').classList.add('hidden');
            // Regresamos la vista al modal principal
            document.getElementById('modalLicencia').classList.remove('hidden');
        }

        // Cerrar modales haciendo clic fuera del recuadro blanco (en el fondo oscuro)
        window.onclick = function(event) {
            const modal1 = document.getElementById('modalLicencia');
            const modal2 = document.getElementById('modalTipoLicencia');
            
            if (event.target === modal1) {
                cerrarModal('modalLicencia');
            }
            if (event.target === modal2) {
                cerrarSubModal();
            }
        }

        // agregar licencia

        // 1. Escuchamos el momento en que el usuario da clic en enviar
        document.getElementById('formNuevaLicencia').addEventListener('submit', function(event) {
            // Evitamos que la página se recargue por defecto
            event.preventDefault(); 

            // 2. Capturamos AUTOMÁTICAMENTE todos los inputs usando FormData
            const datosFormulario = new FormData(this);

            // 3. Enviamos los datos al controlador mediante Fetch
            fetch('/Sistema_LicenciasPro/public/licencias/guardar?ajax=1', {
                method: 'POST',
                body: datosFormulario // Aquí viajan tus variables de forma invisible
            })
                .then(respuesta => {
                    if (!respuesta.ok) throw new Error('Error en el servidor');
                    return respuesta.text();
                })
                .then(data => {
                    // Solo confirmar éxito si el servidor responde OK
                    alert("¡Licencia guardada con éxito!");
                    cerrarModal('modalLicencia');
                    window.location.reload(); 
                })
            .catch(error => {
                console.error("Hubo un error al enviar:", error);
            });
        });






        
// ==========================================
// ESCUCHADOR DEL FORMULARIO ÚNICO (TIPO)
// ==========================================
document.getElementById('formNuevoTipo').addEventListener('submit', function(event) {
    event.preventDefault();

    const datosFormulario = new FormData(this);
    
    // 1. Obtenemos el ID oculto limpiando espacios. 
    // Recuerda verificar que tu input oculto tenga id="idTipoLicencia"
    const idValue = document.getElementById('idTipoLicencia').value.trim();

    // En el servidor `guardarTipo` maneja creación y edición según venga `idTipoLicencia`.
    const rutaDestino = '/Sistema_LicenciasPro/public/licencias/guardarTipo?ajax=1';

    console.log("Enviando a:", rutaDestino, "con ID:", idValue);

    fetch(rutaDestino, {
        method: 'POST',
        body: datosFormulario
    })
    .then(respuesta => {
        if (!respuesta.ok) throw new Error('Error en el servidor');
        return respuesta.text();
    })
    .then(data => {
        // Alerta dinámica según la acción efectuada
        alert(idValue === "" ? "¡Tipo de licencia guardado con éxito!" : "¡Tipo de licencia actualizado con éxito!");
        cerrarSubModal();
        window.location.reload(); 
    })
    .catch(error => {
        console.error("Hubo un error al enviar:", error);
    });
});

// ==========================================
// ACCIÓN ACCIONADA AL TOCAR "EDITAR"
// ==========================================
function editarTipo(id, nombre) {
    // 1. Rellenamos los inputs con los datos de la fila seleccionada
    document.getElementById('idTipoLicencia').value = id;
    document.getElementById('nombreTipoLicencia').value = nombre;

    // 2. Cambiamos el texto del título (Label) a color ámbar/naranja
    const label = document.getElementById('labelFormTipo');
    label.innerText = 'EDITAR TIPO DE LICENCIA';
    label.style.color = '#D97706'; 

    // 3. Forzamos los colores correctos en el botón de Actualizar
    const btnSubmit = document.getElementById('btnSubmitTipo');
    btnSubmit.innerText = 'Actualizar';
    
    // Asignamos fondo naranja y texto blanco de forma explícita
    btnSubmit.style.backgroundColor = '#D97706'; 
    btnSubmit.style.color = '#FFFFFF';
    
    // Añadimos un efecto hover manual por si acaso
    btnSubmit.onmouseover = function() { this.style.backgroundColor = '#B45309'; };
    btnSubmit.onmouseout = function() { this.style.backgroundColor = '#D97706'; };

    // 4. Mostramos el botón de Cancelar quitándole la clase 'hidden'
    document.getElementById('btnCancelarEdicion').classList.remove('hidden');
}

// ==========================================
// FUNCIÓN PARA LIMPIAR / CANCELAR EDICIÓN
// ==========================================
function limpiarFormularioTipo() {
    document.getElementById('idTipoLicencia').value = '';
    document.getElementById('nombreTipoLicencia').value = '';

    const label = document.getElementById('labelFormTipo');
    label.innerText = 'Nuevo Tipo de Licencia';
    label.style.color = ''; 

    const btnSubmit = document.getElementById('btnSubmitTipo');
    btnSubmit.innerText = 'Añadir';
    btnSubmit.style.backgroundColor = '#2CA1C8';
    btnSubmit.style.color = '#FFFFFF';
    
    btnSubmit.onmouseover = function() { this.style.backgroundColor = '#1E85A8'; };
    btnSubmit.onmouseout = function() { this.style.backgroundColor = '#2CA1C8'; };

    document.getElementById('btnCancelarEdicion').classList.add('hidden');
}

// Confirmar y eliminar un tipo via AJAX
function confirmEliminar(id) {
    if (!confirm('¿Seguro que deseas eliminar este tipo de licencia? Esta acción no se puede deshacer.')) return;

    const fd = new FormData();
    fd.append('idTipoLicencia', id);

    fetch('/Sistema_LicenciasPro/public/licencias/eliminarTipo?ajax=1', {
        method: 'POST',
        body: fd
    })
    .then(res => {
        if (!res.ok) throw new Error('Error al eliminar');
        return res.text();
    })
    .then(data => {
        // si el controlador devuelve OK, recargamos para actualizar la lista
        if (data.trim() === 'OK' || data.includes('"result"')) {
            alert('Tipo eliminado');
            window.location.reload();
        } else {
            console.error('Respuesta inesperada:', data);
            alert('No se pudo eliminar el tipo.');
        }
    })
    .catch(err => {
        console.error(err);
        alert('Error al eliminar el tipo.');
    });
}