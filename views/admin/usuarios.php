<?php require_once "views/layouts/header.php"; ?>

<main class="content">
    
    <section class="welcome">

        <a href="index.php?controller=admin&action=dashboard" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Volver al Inicio
        </a>

        <h2>Módulo de Usuarios</h2>
        <p>Seleccione el sub-módulo que desea gestionar.</p>
    </section>

    <section class="module-section">
        <div class="modules-grid">

            <article class="card module-card">
                <i class="fa-solid fa-user module-icon"></i>
                <h4>Gestión de Clientes</h4>
                <p>Dar de alta, editar y consultar expedientes de clientes.</p>
            </article>

            <article class="card module-card">
                <i class="fa-solid fa-user-tie module-icon"></i>
                <h4>Gestión de Empleados</h4>
                <p>Controlar datos internos, cargos y contratos del personal.</p>
            </article>

        </div>
    </section>

</main>

</div>
</div> <?php require_once "views/layouts/footer.php"; ?>