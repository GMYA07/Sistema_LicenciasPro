// Esperamos a que el documento cargue
document.addEventListener('DOMContentLoaded', () => {

    // 1. Capturamos el select y los 3 inputs donde mostraremos los números
    const selectArea = document.getElementById('selectArea');
    const inputTotal = document.getElementById('totalEquipos');
    const inputConLicencia = document.getElementById('equiposConLicencia');
    const inputSinLicencia = document.getElementById('equiposSinLicencia');

    // 2. Le ponemos una "oreja" (listener) al select para saber cuándo cambia
    if(selectArea) {
        selectArea.addEventListener('change', async function() {
            // Sacamos el ID del área que el usuario acaba de elegir
            const idAreaSeleccionada = this.value;

            // Si por alguna razón está vacío, no hacemos nada
            if(!idAreaSeleccionada) return;

            inputTotal.value = '...';
            inputConLicencia.value = '...';
            inputSinLicencia.value = '...';

            try {
                // 3. Hacemos la petición a tu nueva ruta
                const respuesta = await fetch(`${BASE_URL_JS}/bitacoras/obtener_estadisticas?idArea=${idAreaSeleccionada}`);

                // Convertimos la respuesta a JSON
                const datos = await respuesta.json();

                // 4.Inyectamos los datos en los inputs
                inputTotal.value = datos.totalEquipos;
                inputConLicencia.value = datos.equiposConLicencia;
                inputSinLicencia.value = datos.equiposSinLicencia;

            } catch (error) {
                console.error("Error al traer las estadísticas del área:", error);
                // Si falla la red, regresamos los valores a 0 y mostramos un alert
                inputTotal.value = '0';
                inputConLicencia.value = '0';
                inputSinLicencia.value = '0';

                Swal.fire({
                    icon: 'error',
                    title: 'Error de conexión',
                    text: 'No se pudieron cargar las estadísticas de esta área.',
                    customClass: { popup: 'rounded-2xl' }
                });
            }
        });
    }
});

// Validamos que el input exista en la vista actual para que no tire errores en otras páginas
const searchInputBitacoras = document.getElementById('searchInputBitacoras');

if (searchInputBitacoras) {
    searchInputBitacoras.addEventListener('input', function () {

        const query = this.value.toLowerCase();
        // Seleccionamos las filas de la tabla de bitácoras (ignorando la fila de "sin resultados")
        const rows = document.querySelectorAll('#bitacorasTable tbody tr:not(#sinResultadosBitacoras)');

        let visibles = 0;

        rows.forEach(row => {
            // Extraemos el texto de las 3 primeras columnas
            const area = row.querySelector('td:nth-child(1)')?.textContent.toLowerCase() || '';
            const fecha = row.querySelector('td:nth-child(2)')?.textContent.toLowerCase() || '';
            const tecnico = row.querySelector('td:nth-child(3)')?.textContent.toLowerCase() || '';

            // Si lo que el usuario escribe coincide con alguna de las 3 columnas, mostramos la fila
            if (area.includes(query) || fecha.includes(query) || tecnico.includes(query)) {
                row.style.display = '';
                visibles++;
            } else {
                row.style.display = 'none';
            }
        });

        // Mostrar mensaje si no hay coincidencias
        const filaSinResultados = document.getElementById('sinResultadosBitacoras');

        if (filaSinResultados) {
            // Solo mostramos el "sin resultados" si la búsqueda no dio match Y si realmente hay filas en la tabla
            if (visibles === 0 && rows.length > 0) {
                filaSinResultados.classList.remove('hidden');
            } else {
                filaSinResultados.classList.add('hidden');
            }
        }
    });
}