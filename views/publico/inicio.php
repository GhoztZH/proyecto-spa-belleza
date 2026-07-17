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
    <h2 class="section-title">Nuestros servicios destacados</h2>

    <?php if (!empty($serviciosDestacados)): ?>
        <div class="grid grid-3">
            <?php foreach ($serviciosDestacados as $s): ?>
                <article class="card catalog-card">
                    <div class="catalog-content">
                        <h3 class="catalog-title"><i class="fa-solid fa-spa"></i> <?= htmlspecialchars($s['nombre']) ?></h3>
                        <p><?= htmlspecialchars($s['descripcion'] ?? '') ?></p>
                        <p class="catalog-price">$<?= number_format((float)$s['precio'], 2) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-center">Muy pronto podrás explorar nuestros tratamientos de spa y belleza.</p>
    <?php endif; ?>
</section>

<section class="section container">
    <h2 class="section-title">Productos destacados</h2>

    <?php if (!empty($productosDestacados)): ?>
        <div class="grid grid-3">
            <?php foreach ($productosDestacados as $p): ?>
                <article class="card catalog-card">
                    <img src="<?= !empty($p['imagen']) ? htmlspecialchars($p['imagen']) : 'assets/img/no-image.png' ?>"
                        alt="<?= htmlspecialchars($p['nombre']) ?>">
                    <div class="catalog-content">
                        <h3 class="catalog-title"><?= htmlspecialchars($p['nombre']) ?></h3>
                        <p class="catalog-price">$<?= number_format((float)$p['precio'], 2) ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        <p class="text-center">
            <a href="index.php?controller=clienteProd&action=catalogo" class="btn btn-outline">Ver catálogo completo</a>
        </p>
    <?php else: ?>
        <p class="text-center">Estamos preparando un catálogo de productos para el cuidado de tu piel y cabello.</p>
    <?php endif; ?>
</section>

<section class="section container">
    <h2 class="section-title">¿Qué más puedes hacer en Spa & Belleza?</h2>

    <div class="grid grid-3">
        <article class="card catalog-card">
            <div class="catalog-content">
                <h3 class="catalog-title"><i class="fa-solid fa-calendar-check"></i> Citas en línea</h3>
                <p>Agenda tus tratamientos favoritos desde tu cuenta de cliente.</p>
            </div>
        </article>

        <article class="card catalog-card">
            <div class="catalog-content">
                <h3 class="catalog-title"><i class="fa-solid fa-bag-shopping"></i> Compra en línea</h3>
                <p>Explora el catálogo y compra tus productos favoritos desde casa.</p>
            </div>
        </article>

        <article class="card catalog-card">
            <div class="catalog-content">
                <h3 class="catalog-title"><i class="fa-solid fa-user-check"></i> Historial personal</h3>
                <p>Consulta tus citas y compras anteriores en cualquier momento.</p>
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
