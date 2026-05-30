// =========================================================
// JAVASCRIPT CONTROL DE MODALES Y LICENCIAS
// =========================================================

// Funciones generales de apertura y cierre de modales
function abrirModal(idModal, reset = false) {
    const modal = document.getElementById(idModal);

    if (idModal === 'modalLicencia' && reset) {
        resetFormularioLicencia();
    }

    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.classList.add('opacity-100');
    }, 50);
}

function cerrarModal(idModal) {
    const modal = document.getElementById(idModal);

    if (idModal === 'modalLicencia') {
        resetFormularioLicencia();
    }

    modal.classList.add('hidden');
}

function resetFormularioLicencia() {
    const form = document.getElementById('formNuevaLicencia');
    const encabezadoModal = document.getElementById('encabesadoModal');
    const subtituloModal = document.getElementById('suptituloEcabesadoModal');
    const btnSubmit = document.getElementById('btnSubmitLicencia');

    if (form) {
        form.reset();
    }

    const idLicenciaInput = document.getElementById('idLicencia');
    if (idLicenciaInput) {
        idLicenciaInput.value = '';
    }

    const numPermitInput = document.getElementById('numPermitVinculados');
    if (numPermitInput) {
        numPermitInput.value = '1';
    }

    if (encabezadoModal) {
        encabezadoModal.innerText = 'Registrar Nueva Licencia';
    }

    if (subtituloModal) {
        subtituloModal.innerText = 'Llena los datos para añadir un software al inventario';
    }

    if (btnSubmit) {
        btnSubmit.className = 'inline-flex items-center gap-2 bg-[#2CA1C8] hover:bg-[#1E85A8] text-white px-5 py-2.5 rounded-xl font-semibold text-sm shadow-md transition-all cursor-pointer';
        btnSubmit.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v7a2 2 0 002 2h2m3 4h4m-2-4v4m-7-8h10" /></svg> Guardar Licencia';
    }
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

// Lógica para alternar entre el modal de Licencias y el de Tipos de Licencias
function abrirSubModal() {
    document.getElementById('modalLicencia').classList.add('hidden');
    abrirModal('modalTipoLicencia');
}

function cerrarSubModal() {
    document.getElementById('modalTipoLicencia').classList.add('hidden');
    document.getElementById('modalLicencia').classList.remove('hidden');
}

// Cerrar modales haciendo clic fuera del recuadro
window.onclick = function (event) {
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

// Inicializar el filtro de forma automática
filtrarLicencias();

// Registrar/Editar Licencia vía AJAX
document.getElementById('formNuevaLicencia').addEventListener('submit', function (event) {
    event.preventDefault();

    const datosFormulario = new FormData(this);
    const base = window.BASE_URL || '/Sistema_LicenciasPro/public';

    fetch(`${base}/licencias/guardar?ajax=1`, {
        method: 'POST',
        body: datosFormulario
    })
        .then(respuesta => {
            if (!respuesta.ok) throw new Error('Error en el servidor');
            return respuesta.text();
        })
        .then(data => {
            cerrarModal('modalLicencia');
            window.location.reload();
        })
        .catch(error => {
            console.error("Hubo un error al enviar:", error);
        });
});

// Función para rellenar el formulario de edición de licencia
function prepararEdicion(boton) {
    const id = boton.dataset.id;
    const tipo = boton.dataset.tipo;
    const codigo = boton.dataset.codigo;
    const estado = boton.dataset.estado;
    const fechaAdq = boton.dataset.fechaadq;
    const fechaCad = boton.dataset.fechacad;
    const numPermit = boton.dataset.numpermit;

    const idLicenciaInput = document.getElementById('idLicencia');
    const tipoLicenciaSelect = document.getElementById('idTipoLicencia');
    const codigoLicenciaInput = document.getElementById('codigoLicencia');
    const estadoLicenciaSelect = document.getElementById('estadoLicencia');
    const fechaAdquisicionInput = document.getElementById('fechaAdquisision');
    const fechaCaducacionInput = document.getElementById('fechaCaducacion');
    const numPermitInput = document.getElementById('numPermitVinculados');
    const encabezadoModal = document.getElementById('encabesadoModal');
    const subtituloModal = document.getElementById('suptituloEcabesadoModal');

    if (encabezadoModal) {
        encabezadoModal.innerText = 'Editar Licencia';
    }

    if (subtituloModal) {
        subtituloModal.innerText = 'Edita los datos de la licencia';
    }

    if (idLicenciaInput) idLicenciaInput.value = id;
    if (tipoLicenciaSelect) tipoLicenciaSelect.value = tipo;
    if (codigoLicenciaInput) codigoLicenciaInput.value = codigo;
    if (numPermitInput) numPermitInput.value = numPermit || 1;
    if (fechaAdquisicionInput && fechaAdq) {
        fechaAdquisicionInput.value = fechaAdq.split(' ')[0];
    }
    if (fechaCaducacionInput && fechaCad) {
        fechaCaducacionInput.value = fechaCad.split(' ')[0];
    }
    if (estadoLicenciaSelect) {
        estadoLicenciaSelect.value = estado;
    }

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

    abrirModal('modalLicencia');
}

// Cargar estadísticas para las cartas superiores
async function cargarEstadisticas() {
    const vigElem = document.getElementById('licenciasVigentesCount');
    const disElem = document.getElementById('licenciasDisponiblesCount');
    const expElem = document.getElementById('licenciasExpiradasCount');

    if (vigElem) vigElem.textContent = '...';
    if (disElem) disElem.textContent = '...';
    if (expElem) expElem.textContent = '...';

    try {
        const base = window.BASE_URL || '';
        const url = `${base}/licencias/obtenerEstadisticas`;

        const response = await fetch(url);
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const datos = await response.json();
        const counts = {
            instalada: 0,
            noInstalada: 0,
            expirada: 0
        };

        if (Array.isArray(datos)) {
            datos.forEach(row => {
                const estado = (row.estadoLicencia || '')
                    .toString()
                    .trim()
                    .toLowerCase();

                const cantidad = parseInt(row.cantidad, 10) || 0;

                if (estado === 'instalada') {
                    counts.instalada += cantidad;
                } else if (estado === 'noinstalada') {
                    counts.noInstalada += cantidad;
                } else if (estado === 'expirada') {
                    counts.expirada += cantidad;
                }
            });
        }

        if (vigElem) vigElem.textContent = counts.instalada;
        if (disElem) disElem.textContent = counts.noInstalada;
        if (expElem) expElem.textContent = counts.expirada;

    } catch (error) {
        console.error('Error al cargar estadísticas:', error);
        if (vigElem) vigElem.textContent = '0';
        if (disElem) disElem.textContent = '0';
        if (expElem) expElem.textContent = '0';
    }
}

// Toggle visibility of the License Code / Key
document.addEventListener('click', function (event) {
    const toggleBtn = event.target.closest('.toggle-key-visibility');
    if (!toggleBtn) return;

    const container = toggleBtn.closest('.flex');
    if (!container) return;

    const keyElement = container.querySelector('.product-key');
    if (!keyElement) return;

    const actualKey = keyElement.getAttribute('data-key');
    const isMasked = keyElement.textContent.includes('•');

    if (isMasked) {
        keyElement.textContent = actualKey;
        // Switch to eye-slash icon
        toggleBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.893 7.893L21 21m-6.228-6.228l-3.65-3.65m0 0a3 3 0 104.243 4.243m-4.242-4.243L9.88 9.88" />
            </svg>
        `;
        toggleBtn.setAttribute('aria-label', 'Ocultar clave');
    } else {
        keyElement.textContent = '••••••••';
        // Switch to eye icon
        toggleBtn.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        `;
        toggleBtn.setAttribute('aria-label', 'Mostrar clave');
    }
});

document.addEventListener('DOMContentLoaded', cargarEstadisticas);
