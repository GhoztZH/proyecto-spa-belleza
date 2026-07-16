<?php
$tituloPagina = "Inicio";
require_once "views/layouts/header_publico.php";
?>

<!-- Autor: Integrante 1 -->

<section class="hero">
    <div class="hero-content">
        <h1>Bienestar y belleza en un solo lugar</h1>
        <p>Agenda tus tratamientos favoritos y descubre nuestros productos pensados para cuidar de ti.</p>
        <?php if (!isset($_SESSION['usuario'])): ?>
            <a href="index.php?controller=auth&action=registro" class="btn btn-primary">
                <i class="fa-solid fa-user-plus"></i> Crear mi cuenta
            </a>
        <?php else: ?>
            <a href="index.php?controller=area-cliente&action=inicio" class="btn btn-primary">
                <i class="fa-solid fa-arrow-right"></i> Ir a mi cuenta
            </a>
        <?php endif; ?>
    </div>
</section>

<section class="section container">
    <h2 class="section-title">¿Qué puedes hacer en Spa & Belleza?</h2>

    <div class="grid grid-3">
        <article class="card catalog-card">
            <div class="catalog-content">
                <h3 class="catalog-title"><i class="fa-solid fa-spa"></i> Servicios</h3>
                <p>Muy pronto podrás explorar y reservar nuestros tratamientos de spa y belleza.</p>
            </div>
        </article>

        <article class="card catalog-card">
            <div class="catalog-content">
                <h3 class="catalog-title"><i class="fa-solid fa-box-open"></i> Productos</h3>
                <p>Estamos preparando un catálogo de productos para el cuidado de tu piel y cabello.</p>
            </div>
        </article>

        <article class="card catalog-card">
            <div class="catalog-content">
                <h3 class="catalog-title"><i class="fa-solid fa-calendar-check"></i> Citas en línea</h3>
                <p>La agenda de citas estará disponible próximamente desde tu cuenta de cliente.</p>
            </div>
        </article>
    </div>
</section>

<section class="cta">
    <h2>¿Aún no tienes una cuenta?</h2>
    <p>Regístrate en unos segundos y sé de los primeros en reservar cuando abramos la agenda de citas.</p>
    <?php if (!isset($_SESSION['usuario'])): ?>
        <a href="index.php?controller=auth&action=registro" class="btn btn-outline">Registrarme ahora</a>
    <?php endif; ?>
</section>

<?php require_once "views/layouts/footer.php"; ?>
