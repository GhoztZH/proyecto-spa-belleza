// autor: Maria Belen Cassiaux Guerrero
// Gestión de citas (flujo administrador): listado con filtros server-side,
// edición de estado/empleado/observación y eliminación.
//
// NOTA: los inputs de "views/admin/citas_gestion.php" llaman a actualizarTabla()
// en sus eventos onchange/oninput; por eso la función de carga/filtrado se
// llama igual (antes se llamaba renderTabla() y nunca se ejecutaba).

let debounceBusquedaAdmin = null;

document.addEventListener("DOMContentLoaded", () => {
    actualizarTabla();
    cargarEmpleados();

    // El buscador de texto consulta al servidor en cada tecla, con debounce
    // para no disparar una petición por cada pulsación.
    const buscador = document.getElementById("buscadorGeneral");
    if (buscador) {
        buscador.addEventListener("input", () => {
            clearTimeout(debounceBusquedaAdmin);
            debounceBusquedaAdmin = setTimeout(actualizarTabla, 300);
        });
    }
});

/**
 * Consulta las citas al servidor aplicando los filtros vigentes
 * (fecha, texto de búsqueda y estado) y repinta la tabla.
 */
async function actualizarTabla() {
    const fecha = document.getElementById("filtroFecha").value;
    const buscar = encodeURIComponent(document.getElementById("buscadorGeneral").value.trim());
    const estado = document.getElementById("filtroEstado").value;

    const url = `index.php?controller=citas&action=obtenerCitas&fecha=${fecha}&buscar=${buscar}&estado=${estado}`;
    const cuerpo = document.getElementById("cuerpoTabla");

    try {
        cuerpo.innerHTML = "<tr><td colspan='8'>Cargando datos...</td></tr>";
        const response = await fetch(url);

        if (!response.ok) throw new Error("Error en el servidor");

        const citas = await response.json();
        cuerpo.innerHTML = "";

        if (!citas || citas.length === 0) {
            cuerpo.innerHTML = "<tr><td colspan='8'>No hay citas registradas.</td></tr>";
            return;
        }

        // Una cita puede tener varios servicios asociados (varias filas con
        // el mismo id_cita); se agrupan para mostrar una sola fila por cita.
        const citasAgrupadas = {};

        citas.forEach(c => {
            const key = c.id_cita;
            if (!citasAgrupadas[key]) {
                citasAgrupadas[key] = { ...c, lista_servicios: [c.nombre_servicio] };
            } else if (!citasAgrupadas[key].lista_servicios.includes(c.nombre_servicio)) {
                citasAgrupadas[key].lista_servicios.push(c.nombre_servicio);
            }
        });

        Object.values(citasAgrupadas).forEach(c => {
            const row = document.createElement("tr");
            row.setAttribute("data-id", c.id_cita);
            // Se guarda el id del empleado asignado para precargar el
            // select del modal de edición (ver abrirModal).
            row.setAttribute("data-id-empleado", c.id_empleado ?? "");

            row.innerHTML = `
                <td>${c.nombre_cliente || 'N/A'}</td>
                <td>${c.lista_servicios.join(", ")}</td>
                <td>
                    ${c.nombre_empleado
                        ? `${c.nombre_empleado} ${c.apellido_empleado} (${c.cargo_empleado})`
                        : '<em>Sin asignar</em>'}
                </td>
                <td>${c.fecha}</td>
                <td>${c.hora.substring(0, 5)}</td>
                <td>${c.estado}</td>
                <td>${c.observacion || ''}</td>
                <td>
                    <button class="btn btn-warning-soft" onclick="abrirModal(${c.id_cita})"><i class="fas fa-edit"></i></button>
                    <button class="btn btn-danger" onclick="eliminarCita(${c.id_cita})"><i class="fas fa-trash"></i></button>
                </td>
            `;
            cuerpo.appendChild(row);
        });
    } catch (error) {
        console.error("Error al cargar la tabla:", error);
        cuerpo.innerHTML = "<tr><td colspan='8'>Error al cargar los datos.</td></tr>";
    }
}

/**
 * Abre el modal de edición precargando los datos de la fila seleccionada.
 */
function abrirModal(idCita) {
    const fila = document.querySelector(`tr[data-id="${idCita}"]`);
    if (!fila) return alert("Error: No se pudieron cargar los datos.");

    const celdas = fila.getElementsByTagName("td");
    document.getElementById("editId").value = idCita;
    document.getElementById("editEstado").value = celdas[5].innerText.trim();
    document.getElementById("editObservacion").value = celdas[6].innerText.trim() === 'null' ? '' : celdas[6].innerText.trim();
    document.getElementById("editEmpleado").value = fila.getAttribute("data-id-empleado") || "";

    document.getElementById("modalEdicion").style.display = "block";
}

function cerrarModal() {
    document.getElementById("modalEdicion").style.display = "none";
    document.getElementById("formEdicion").reset();
}

/**
 * Envía los cambios del modal (estado, empleado, observación) al servidor.
 */
async function guardarEdicion() {
    const estado = document.getElementById("editEstado").value;

    if (!estado) {
        alert("Por favor, seleccione un estado válido.");
        return;
    }

    const formData = new FormData(document.getElementById("formEdicion"));
    try {
        const response = await fetch('index.php?controller=citas&action=actualizar', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.success) {
            alert("Cita actualizada correctamente.");
            cerrarModal();
            actualizarTabla();
        } else {
            alert("Error al actualizar: " + (result.message || "Intente nuevamente."));
        }
    } catch (error) {
        console.error("Error:", error);
        alert("Error de conexión con el servidor.");
    }
}

/**
 * Elimina una cita previa confirmación del usuario.
 */
async function eliminarCita(id) {
    if (!confirm("¿Estás seguro de eliminar esta cita?")) return;

    try {
        const response = await fetch(`index.php?controller=citas&action=eliminar&id=${encodeURIComponent(id)}`);
        const result = await response.json();

        if (result.success) {
            alert("Cita eliminada correctamente");
            actualizarTabla();
        } else {
            alert("Error al eliminar: " + (result.message || "Error desconocido"));
        }
    } catch (error) {
        console.error("Error en eliminarCita:", error);
    }
}

/**
 * Carga el listado de empleados en el <select> del modal de edición.
 */
async function cargarEmpleados() {
    try {
        const response = await fetch('index.php?controller=citas&action=obtenerEmpleados');
        const empleados = await response.json();
        const select = document.getElementById('editEmpleado');
        select.innerHTML = '<option value="">-- Sin asignar --</option>';
        empleados.forEach(emp => {
            const nombreCompleto = `${emp.nombre} ${emp.apellido} - ${emp.cargo}`;
            select.innerHTML += `<option value="${emp.id_empleado}">${nombreCompleto}</option>`;
        });
    } catch (err) {
        console.error("Error cargando empleados", err);
    }
}

/**
 * Restablece los filtros y vuelve a consultar el listado completo.
 */
function limpiarFiltros() {
    document.getElementById("filtroFecha").value = "";
    document.getElementById("buscadorGeneral").value = "";
    document.getElementById("filtroEstado").value = "todos";
    actualizarTabla();
}
