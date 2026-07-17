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
                <p>Consulta tu agenda o reserva una nueva cita.</p>
                <div class="cliente-inicio-acciones">
                    <a href="index.php?controller=citas&action=miAgenda" class="btn btn-secondary">Ver mi agenda</a>
                    <a href="index.php?controller=citas&action=crear" class="btn btn-primary">Reservar cita</a>
                </div>
            </div>
        </article>

        <article class="card catalog-card">
            <div class="catalog-content">
                <h3 class="catalog-title"><i class="fa-solid fa-bag-shopping"></i> Mis compras</h3>
                <p>Revisa tu historial de compras o explora el catálogo.</p>
                <div class="cliente-inicio-acciones">
                    <a href="index.php?controller=area-cliente&action=compras" class="btn btn-secondary">Ver mis compras</a>
                    <a href="index.php?controller=clienteProd&action=catalogo" class="btn btn-primary">Ir al catálogo</a>
                </div>
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
