/*==================================================
    ADMIN.JS
    Manejo de eventos globales del Panel
==================================================*/

document.addEventListener('DOMContentLoaded', () => {
    
    // Inicializar manejadores de eventos
    initDashboardEvents();
    initNavbarEvents();
    
});

/**
 * Maneja los eventos dentro del área del Dashboard / Módulos
 */
function initDashboardEvents() {
    const modulesGrid = document.querySelector('.modules-grid');
    
    // Si no estamos en una pantalla con cuadrícula de módulos, salir
    if (!modulesGrid) return;

    // Delegación de eventos para las Tarjetas de los Módulos
    modulesGrid.addEventListener('click', (e) => {
        // Detecta si el clic ocurrió dentro de una tarjeta con el atributo data-url
        const card = e.target.closest('.module-card[data-url]');
        
        if (card) {
            const url = card.getAttribute('data-url');
            if (url && url !== '#') {
                window.location.href = url;
            }
        }
    });
}

/**
 * Maneja los eventos globales de la barra superior (Navbar)
 */
function initNavbarEvents() {
    // Capturar el botón de cerrar sesión
    const logoutBtn = document.querySelector('.admin-navbar .btn-danger');

    if (logoutBtn) {
        logoutBtn.addEventListener('click', (e) => {
            // Detener la redirección inmediata del enlace
            e.preventDefault(); 
            
            // Confirmación nativa
            const confirmar = confirm('¿Está seguro de que desea cerrar sesión en el sistema?');
            
            if (confirmar) {
                // Si acepta, procedemos a la URL de logout de PHP
                window.location.href = logoutBtn.getAttribute('href');
            }
        });
    }
}