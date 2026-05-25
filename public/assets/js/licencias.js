
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

        function normalizarTexto(valor) {
            return (valor || '')
                .toString()
                .toLowerCase()
                .normalize('NFD')
                .replace(/[\u0300-\u036f]/g, '')
                .trim();
        }

        function filtrarLicencias() {
            const buscador = document.getElementById('buscarLicencia');
            const filtroEstado = document.getElementById('filtro-estado');
            const filas = document.querySelectorAll('tbody tr[data-search]');
            const filaSinResultados = document.getElementById('sinResultadosLicencias');

            const textoBusqueda = normalizarTexto(buscador ? buscador.value : '');
            const estadoSeleccionado = normalizarTexto(filtroEstado ? filtroEstado.value : '');

            let visibles = 0;

            filas.forEach((fila) => {
                const contenidoFila = normalizarTexto(fila.dataset.search);
                const estadoFila = normalizarTexto(fila.dataset.estado);

                const coincideTexto = textoBusqueda === '' || contenidoFila.includes(textoBusqueda);
                const coincideEstado = estadoSeleccionado === '' || estadoFila === estadoSeleccionado;
                const mostrar = coincideTexto && coincideEstado;

                fila.classList.toggle('hidden', !mostrar);

                if (mostrar) {
                    visibles += 1;
                }
            });

            if (filaSinResultados) {
                filaSinResultados.classList.toggle('hidden', visibles !== 0);
            }
        }

        function aplicarBotonGuardar(btn, modoEdicion, textoDefault, textoEdicion, iconoEdicion) {
            if (!btn) return;

            btn.classList.remove('bg-[#2CA1C8]', 'hover:bg-[#1E85A8]', 'bg-[#D97706]', 'hover:bg-[#B45309]');
            btn.classList.add('inline-flex', 'items-center', 'gap-2');

            if (modoEdicion) {
                btn.classList.add('bg-[#D97706]', 'hover:bg-[#B45309]');
                btn.innerHTML = iconoEdicion || '';
                btn.innerHTML += `<span>${textoEdicion || 'Actualizar'}</span>`;
            } else {
                btn.classList.add('bg-[#2CA1C8]', 'hover:bg-[#1E85A8]');
                if (typeof textoDefault === 'string' && textoDefault.includes('<svg')) {
                    btn.innerHTML = textoDefault;
                } else {
                    btn.innerText = textoDefault || btn.textContent.trim();
                }
            }

            btn.style.color = '#FFFFFF';
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

        const buscadorLicencias = document.getElementById('buscarLicencia');
        const filtroEstadoLicencias = document.getElementById('filtro-estado');

        if (buscadorLicencias) {
            buscadorLicencias.addEventListener('input', filtrarLicencias);
        }

        if (filtroEstadoLicencias) {
            filtroEstadoLicencias.addEventListener('change', filtrarLicencias);
        }

        filtrarLicencias();

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
    const idValue = document.getElementById('idTipoLicenciaTipo').value.trim();

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
    document.getElementById('idTipoLicenciaTipo').value = id;
    document.getElementById('nombreTipoLicencia').value = nombre;

    // 2. Cambiamos el texto del título (Label) a color ámbar/naranja
    const label = document.getElementById('labelFormTipo');
    label.innerText = 'EDITAR TIPO DE LICENCIA';
    label.style.color = '#D97706'; 

    // 3. Forzamos los colores correctos en el botón de Actualizar
    const btnSubmit = document.getElementById('btnSubmitTipo');
    btnSubmit.innerText = 'Actualizar';
    aplicarBotonGuardar(btnSubmit, true, 'Añadir', 'Actualizar', '');

    // 4. Mostramos el botón de Cancelar quitándole la clase 'hidden'
    document.getElementById('btnCancelarEdicion').classList.remove('hidden');
}

// ==========================================
// FUNCIÓN PARA LIMPIAR / CANCELAR EDICIÓN
// ==========================================
function limpiarFormularioTipo() {
    document.getElementById('idTipoLicenciaTipo').value = '';
    document.getElementById('nombreTipoLicencia').value = '';

    const label = document.getElementById('labelFormTipo');
    label.innerText = 'Nuevo Tipo de Licencia';
    label.style.color = ''; 

    const btnSubmit = document.getElementById('btnSubmitTipo');
    btnSubmit.innerText = 'Añadir';
    aplicarBotonGuardar(btnSubmit, false, 'Añadir', 'Actualizar', '');

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

// funcion para editar licencia (similar a editar tipo pero con más campos)
function prepararEdicion(boton) {
    // 1. Jalamos los datos desde los atributos 'data-*' del botón de forma segura
    const id = boton.dataset.id;
    const tipo = boton.dataset.tipo;
    const codigo = boton.dataset.codigo;
    const estado = boton.dataset.estado;

    // 2. Rellenamos los inputs de tu formulario único de licencias
    const idLicenciaInput = document.getElementById('idLicencia');
    const tipoLicenciaSelect = document.getElementById('idTipoLicencia');
    const codigoLicenciaInput = document.getElementById('codigoLicencia');
    const estadoLicenciaSelect = document.getElementById('estadoLicencia');

    if (idLicenciaInput) idLicenciaInput.value = id;
    if (tipoLicenciaSelect) tipoLicenciaSelect.value = tipo;
    if (codigoLicenciaInput) codigoLicenciaInput.value = codigo;
    
    if (estadoLicenciaSelect) {
        estadoLicenciaSelect.value = estado;
    }

    // 3. Transformamos el botón del formulario a modo "Actualizar"
    const btnSubmit = document.getElementById('btnSubmitLicencia');
    if (btnSubmit) {
        aplicarBotonGuardar(
            btnSubmit,
            false,
            '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v7a2 2 0 002 2h2m3 4h4m-2-4v4m-7-8h10" /></svg> Guardar Licencia',
            '',
            ''
        );
    }

    // 4. Abrimos el modal una vez cargados los datos
    abrirModal('modalLicencia');

}

// Cargar estadísticas para las cartas (consulta al backend)
async function cargarEstadisticas() {

    const vigElem = document.getElementById('licenciasVigentesCount');
    const disElem = document.getElementById('licenciasDisponiblesCount');
    const expElem = document.getElementById('licenciasExpiradasCount');

    // Estado inicial
    if (vigElem) vigElem.textContent = '...';
    if (disElem) disElem.textContent = '...';
    if (expElem) expElem.textContent = '...';

    try {

        const base = window.BASE_URL || '';
        const url = `${base}/licencias/obtenerEstadisticas`;

        console.log('Cargando estadísticas desde:', url);

        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const datos = await response.json();

        console.log('Datos recibidos:', datos);

        const counts = {
            vigente: 0,
            disponible: 0,
            expirada: 0
        };

        if (Array.isArray(datos)) {

            datos.forEach(row => {

                const estado = (row.estadoLicencia || '')
                    .toString()
                    .trim()
                    .toLowerCase();

                const cantidad = parseInt(row.cantidad, 10) || 0;

                if (estado.includes('vigente')) {

                    counts.vigente += cantidad;

                } else if (estado.includes('no instalada')) {

                    counts.disponible += cantidad;

                } else if (estado.includes('expirada')) {

                    counts.expirada += cantidad;

                }

            });

        }

        // Actualizar cards
        if (vigElem) vigElem.textContent = counts.vigente;
        if (disElem) disElem.textContent = counts.disponible;
        if (expElem) expElem.textContent = counts.expirada;

        console.log('Cards actualizadas:', counts);

    } catch (error) {

        console.error('Error al cargar estadísticas:', error);

        if (vigElem) vigElem.textContent = '0';
        if (disElem) disElem.textContent = '0';
        if (expElem) expElem.textContent = '0';

    }

}

// Ejecutar automáticamente
document.addEventListener('DOMContentLoaded', cargarEstadisticas);
