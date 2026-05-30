// =========================================================
// JAVASCRIPT CONTROL PARA TIPOS DE LICENCIAS
// =========================================================

// Escuchador del formulario único de tipo
document.getElementById('formNuevoTipo').addEventListener('submit', function (event) {
    event.preventDefault();

    const datosFormulario = new FormData(this);
    const idValue = document.getElementById('idTipoLicenciaTipo').value.trim();
    const base = window.BASE_URL || '/Sistema_LicenciasPro/public';
    const rutaDestino = `${base}/licencias/guardarTipo?ajax=1`;

    console.log("Enviando a:", rutaDestino, "con ID:", idValue);

    fetch(rutaDestino, {
        method: 'POST',
        body: datosFormulario
    })
        .then(respuesta => {
            if (!respuesta.ok) {
                return respuesta.text().then(text => { throw new Error(text) });
            }
            return respuesta.text();
        })
        .then(data => {
            cerrarSubModal();
            window.location.reload();
        })
        .catch(error => {
            console.error("Hubo un error al enviar:", error);
            alert("Error al guardar el tipo de licencia: " + error.message);
        });
});

// Acción accionada al presionar "Editar" en la tabla de tipos
function editarTipo(id, nombre, categoria) {
    document.getElementById('idTipoLicenciaTipo').value = id;
    document.getElementById('nombreTipoLicencia').value = nombre;
    
    const selectCategoria = document.getElementById('categoriaLicencia');
    if (selectCategoria) {
        selectCategoria.value = categoria;
    }

    const label = document.getElementById('labelFormTipo');
    if (label) {
        label.innerText = 'EDITAR TIPO DE LICENCIA';
        label.style.color = '#D97706';
    }

    const btnSubmit = document.getElementById('btnSubmitTipo');
    if (btnSubmit) {
        btnSubmit.innerText = 'Actualizar';
        if (typeof aplicarBotonGuardar === 'function') {
            aplicarBotonGuardar(btnSubmit, true, 'Añadir', 'Actualizar', '');
        }
    }

    const btnCancelar = document.getElementById('btnCancelarEdicion');
    if (btnCancelar) {
        btnCancelar.classList.remove('hidden');
    }
}

// Limpiar formulario y cancelar edición
function limpiarFormularioTipo() {
    document.getElementById('idTipoLicenciaTipo').value = '';
    document.getElementById('nombreTipoLicencia').value = '';
    
    const selectCategoria = document.getElementById('categoriaLicencia');
    if (selectCategoria) {
        selectCategoria.value = '';
    }

    const label = document.getElementById('labelFormTipo');
    if (label) {
        label.innerText = 'Nuevo Tipo de Licencia';
        label.style.color = '';
    }

    const btnSubmit = document.getElementById('btnSubmitTipo');
    if (btnSubmit) {
        btnSubmit.innerText = 'Añadir';
        if (typeof aplicarBotonGuardar === 'function') {
            aplicarBotonGuardar(btnSubmit, false, 'Añadir', 'Actualizar', '');
        }
    }

    const btnCancelar = document.getElementById('btnCancelarEdicion');
    if (btnCancelar) {
        btnCancelar.classList.add('hidden');
    }
}

// Confirmar y eliminar un tipo de licencia
function confirmEliminar(id) {
    if (!confirm('¿Seguro que deseas eliminar este tipo de licencia? Esta acción no se puede deshacer.')) return;

    const fd = new FormData();
    fd.append('idTipoLicencia', id);

    const base = window.BASE_URL || '/Sistema_LicenciasPro/public';
    const url = `${base}/licencias/eliminarTipo?ajax=1`;

    fetch(url, {
        method: 'POST',
        body: fd
    })
        .then(res => {
            if (!res.ok) throw new Error('Error al eliminar');
            return res.text();
        })
        .then(data => {
            if (data.trim() === 'OK') {
                alert('Tipo de licencia eliminado correctamente.');
                window.location.reload();
            } else {
                console.error('Respuesta inesperada:', data);
                alert('No se pudo eliminar el tipo de licencia.');
            }
        })
        .catch(err => {
            console.error(err);
            alert('Error al eliminar el tipo de licencia.');
        });
}
