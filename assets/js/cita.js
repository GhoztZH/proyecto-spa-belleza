// Autor: Maria Belen Cassiaux Guerrero
//
// Listado de citas con filtros server-side, reutilizado por dos vistas:
//   - views/admin/citas_gestion.php   -> no usa este script (usa crudReserva.js)
//   - views/cliente/citas/cita_agenda.php -> agenda personal del cliente
//
// La vista que incluye este script DEBE declarar antes, en un <script>,
// la acción del controlador a consultar:
//   const accionTabla = "obtenerCitasCliente";
// Si no se declara, se usa "obtenerCitas" (solo Administrador) por defecto.
const accion = typeof accionTabla !== "undefined"
    ? accionTabla
    : "obtenerCitas";

let debounceBusquedaCliente = null;

document.addEventListener("DOMContentLoaded", () => {
    cargarTabla();

    // Búsqueda en tiempo real con debounce para no saturar el servidor.
    const buscador = document.getElementById("buscadorGeneral");
    if (buscador) {
        buscador.addEventListener("input", () => {
            clearTimeout(debounceBusquedaCliente);
            debounceBusquedaCliente = setTimeout(cargarTabla, 300);
        });
    }
});

/**
 * Obtiene las citas desde el servidor (según los filtros activos) y
 * actualiza la tabla.
 */
async function cargarTabla() {
    const cuerpoCita = document.getElementById("cuerpoCita");
    if (!cuerpoCita) return;

    const fecha = document.getElementById("filtroFecha")?.value ?? "";
    const estado = document.getElementById("filtroEstado")?.value ?? "todos";
    const buscar = document.getElementById("buscadorGeneral")?.value.trim() ?? "";

    const url =
        `index.php?controller=citas&action=${accion}` +
        `&fecha=${encodeURIComponent(fecha)}` +
        `&buscar=${encodeURIComponent(buscar)}` +
        `&estado=${encodeURIComponent(estado)}`;

    try {
        cuerpoCita.innerHTML = "<tr><td colspan='7'>Cargando datos...</td></tr>";

        const response = await fetch(url);
        if (!response.ok) throw new Error(`HTTP ${response.status}`);

        const citas = await response.json();
        renderTabla(citas);
    } catch (error) {
        console.error(error);
        cuerpoCita.innerHTML =
            `<tr>
                <td colspan="7" style="color:red;text-align:center">
                    Error al cargar las citas.
                </td>
            </tr>`;
    }
}

/**
 * Dibuja las filas de la tabla, agrupando por fecha+hora+cliente
 * (una cita puede tener varios servicios asociados).
 */
function renderTabla(citas) {
    const cuerpoCita = document.getElementById("cuerpoCita");
    cuerpoCita.innerHTML = "";

    if (!Array.isArray(citas) || citas.length === 0) {
        cuerpoCita.innerHTML =
            "<tr><td colspan='7' style='text-align:center;'>No se encontraron citas.</td></tr>";
        return;
    }

    const agrupadas = {};

    citas.forEach(cita => {
        const key = `${cita.fecha}_${cita.hora}_${cita.id_cliente}`;

        if (!agrupadas[key]) {
            agrupadas[key] = { ...cita, servicios: new Set() };
        }

        if (cita.nombre_servicio) {
            agrupadas[key].servicios.add(cita.nombre_servicio);
        }
    });

    Object.values(agrupadas).forEach(cita => {
        const fila = document.createElement("tr");

        fila.innerHTML = `
            <td>${cita.nombre_cliente ?? "N/A"}</td>
            <td>${[...cita.servicios].join(", ") || "N/A"}</td>
            <td>${cita.nombre_empleado ?? "<em>No asignado</em>"}</td>
            <td>${cita.fecha}</td>
            <td>${cita.hora.substring(0, 5)}</td>
            <td>${cita.estado}</td>
            <td>${cita.observacion ?? ""}</td>
        `;

        cuerpoCita.appendChild(fila);
    });
}

/**
 * Restablece los filtros y vuelve a consultar el listado completo.
 */
function limpiarFiltros() {
    document.getElementById("filtroFecha").value = "";
    document.getElementById("buscadorGeneral").value = "";
    document.getElementById("filtroEstado").value = "todos";
    cargarTabla();
}
