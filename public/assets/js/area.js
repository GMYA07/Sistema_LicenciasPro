/**
 * Abre el modal con animaciones suaves de Tailwind y prepara el formulario.
 * @param {string} modalId - El ID del modal HTML ('modalArea').
 * @param {Object|null} datos - Objeto con los datos del área para editar, o null para agregar.
 */
function abrirModal(modalId, datos = null) {
    const modal = document.getElementById(modalId);
    const content = document.getElementById('modalContentArea');

    if (modal && content) {
        // 1. Mostrar el fondo (quita invisible y activa la opacidad progresivamente)
        modal.classList.remove('invisible', 'pointer-events-none');
        modal.classList.add('opacity-100');

        // 2. Animar el contenedor interno (escala al 100% y opacidad total)
        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');

        // Cerrar modal al hacer clic en el fondo gris translúcido
        modal.onclick = function (e) {
            if (e.target === modal) {
                cerrarModal(modalId);
            }
        };

        // 3. Determinar si es AGREGAR o EDITAR
        if (datos) {
            // Rellenamos el formulario usando la función dedicada de edición
            editarArea(datos);
        } else {
            // Limpiamos el formulario para un nuevo registro
            document.getElementById('modalTitleArea').textContent = "Agregar Nueva Área";
            document.getElementById('formArea').reset();
            document.getElementById('idArea').value = "";
        }
    }
}

/**
 * Cierra el modal aplicando las transiciones de salida de Tailwind.
 * @param {string} modalId - El ID del modal HTML.
 */
function cerrarModal(modalId) {
    const modal = document.getElementById(modalId);
    const content = document.getElementById('modalContentArea');

    if (modal && content) {
        // 1. Revertir la animación del contenedor interno
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        // 2. Desvanecer el fondo
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0', 'pointer-events-none');

        // 3. Volver a aplicar la propiedad 'invisible' tras completarse la transición (300ms)
        setTimeout(() => {
            if (modal.classList.contains('opacity-0')) {
                modal.classList.add('invisible');
            }
        }, 300);
    }
}

/**
 * Prepara y rellena el formulario con los datos del área seleccionada para editar.
 * Esta función es llamada internamente por abrirModal().
 * * @param {Object} datos - Objeto con { idArea, nombreArea, edificio, numEquipos, estadoCentroComputo }
 */
function editarArea(datos) {
    // 1. Cambiamos el título del modal para reflejar la acción de edición
    document.getElementById('modalTitleArea').textContent = "Editar Área";

    // 2. Asignamos el ID al input hidden para que PHP sepa que es un UPDATE
    document.getElementById('idArea').value = datos.idArea;

    // 3. Rellenamos los campos del formulario con los datos existentes
    document.getElementById('nombreArea').value = datos.nombreArea;
    document.getElementById('edificio').value = datos.edificio;
    document.getElementById('numEquipos').value = datos.numEquipos;

    // Convertimos el estado a string ('1' o '0') para que coincida con el valor de los <option> del <select>
    document.getElementById('estadoCentroComputo').value = datos.estadoCentroComputo ? "1" : "0";

}

/**
 * Realiza validaciones previas en el navegador antes de enviar los datos al servidor.
 * Puedes vincular esta función al evento 'onsubmit' del formulario.
 * @param {Event} event - El evento de submit del formulario.
 * @returns {boolean} - Retorna true si todo es válido, de lo contrario false para detener el envío.
 */
function guardarArea(event) {
    const nombre = document.getElementById('nombreArea').value.trim();
    const edificio = document.getElementById('edificio').value.trim();
    const equipos = parseInt(document.getElementById('numEquipos').value, 10);

    // Validación básica de seguridad
    if (nombre === "" || edificio === "") {
        event.preventDefault(); // Detiene el envío del formulario
        alert("Por favor, completa todos los campos obligatorios.");
        return false;
    }

    if (isNaN(equipos) || equipos < 0) {
        event.preventDefault();
        alert("El número de equipos debe ser un número igual o mayor a 0.");
        return false;
    }

    // Si todo está correcto, dejamos que el formulario continúe su envío normal hacia PHP
    return true;
}

// Vinculamos la validación de manera segura una vez que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', () => {
    const formulario = document.getElementById('formArea');
    if (formulario) {
        formulario.addEventListener('submit', guardarArea);
    }
});

// eliminar

function abrirModalEliminacion(modalId, idArea) {
    const modal = document.getElementById(modalId);
    const content = document.getElementById('modalConfirmacion');

    if (modal && content) {

        modal.classList.remove('invisible', 'pointer-events-none');
        modal.classList.add('opacity-100');

        content.classList.remove('scale-95', 'opacity-0');
        content.classList.add('scale-100', 'opacity-100');

        // Guardar el id en el input hidden
        document.getElementById('idAreaEliminar').value = idArea;

        modal.onclick = function (e) {
            if (e.target === modal) {
                cerrarModal(modalId);
            }
        };
    }
}

document.getElementById('searchInput').addEventListener('input', function () {

    const query = this.value.toLowerCase();

    const rows = document.querySelectorAll('#areasTable tbody tr:not(#sinResultadosAreas)');

    let visibles = 0;

    rows.forEach(row => {

        const nombre =
            row.querySelector('td:nth-child(1)')
                ?.textContent.toLowerCase() || '';

        const edificio =
            row.querySelector('td:nth-child(2)')
                ?.textContent.toLowerCase() || '';

        if (nombre.includes(query) || edificio.includes(query)) {

            row.style.display = '';
            visibles++;

        } else {

            row.style.display = 'none';

        }

    });

    // Mostrar mensaje si no hay coincidencias
    const filaSinResultados =
        document.getElementById('sinResultadosAreas');

    if (filaSinResultados) {

        if (visibles === 0) {
            filaSinResultados.classList.remove('hidden');
        } else {
            filaSinResultados.classList.add('hidden');
        }

    }

});