<?php
$tituloPagina = "Mi Cuenta";
require_once "views/layouts/header_publico.php";
?>

<!-- Autor: Integrante 1 -->

<section class="section container">
    <h2 class="section-title">
        Hola, <?= htmlspecialchars($usuario['nombre'] . ' ' . $usuario['apellido']) ?> 👋
    </h2>

    <div class="grid grid-3">
        <article class="card catalog-card">
            <div class="catalog-content">
                <h3 class="catalog-title"><i class="fa-solid fa-calendar-check"></i> Mis citas</h3>
                <p>Aquí podrás ver y agendar tus próximas citas muy pronto.</p>
            </div>
        </article>

        <article class="card catalog-card">
            <div class="catalog-content">
                <h3 class="catalog-title"><i class="fa-solid fa-bag-shopping"></i> Mis compras</h3>
                <p>El historial de tus compras de productos estará disponible próximamente.</p>
            </div>
        </article>

        <article class="card catalog-card">
            <div class="catalog-content">
                <h3 class="catalog-title"><i class="fa-solid fa-user"></i> Mi perfil</h3>
                <p>Usuario: <strong><?= htmlspecialchars($usuario['username']) ?></strong></p>
            </div>
        </article>
    </div>
</section>

<?php require_once "views/layouts/footer.php"; ?>
