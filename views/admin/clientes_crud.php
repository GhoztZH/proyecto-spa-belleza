<?php
require_once "views/layouts/header.php";
?>

<div class="container" style="margin-top: var(--space-6); margin-bottom: var(--space-10);">

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-6);">
        <div>
            <h1 style="font-size: var(--font-size-2xl); font-weight: var(--font-bold); color: var(--text-primary); margin: 0;">
                Gestión de Clientes
            </h1>
        </div>
        <button type="button" class="btn btn-primary" id="btnToggleFormulario">
            <i class="fas fa-user-plus"></i> <span id="btnText">Nuevo Cliente</span>
        </button>
    </div>

    <?php if (isset($_GET['status'])): ?>
        <?php
        $alertClass = ($_GET['status'] == 'success' || $_GET['status'] == 'updated') ? 'alert-success' : 'alert-danger';
        ?>
        <div class="alert <?= $alertClass ?>" style="display: flex; justify-content: space-between; align-items: center;">
            <span>
                <?php
                if ($_GET['status'] == 'success') echo "Cliente registrado correctamente.";
                if ($_GET['status'] == 'updated') echo "Cliente actualizado correctamente.";
                if ($_GET['status'] == 'deleted') echo "Cliente eliminado lógicamente del sistema.";
                ?>
            </span>
            <button type="button" onclick="this.parentElement.style.display='none';" style="background: transparent; border: none; cursor: pointer; color: inherit; font-weight: bold;">&times;</button>
        </div>
    <?php endif; ?>

    <div id="seccionFormulario" class="card hidden" style="margin-bottom: var(--space-7); border: 1px solid var(--border-color);">
        <h3 class="card-title" style="font-size: var(--font-size-lg); color: var(--color-primary); display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-user-plus"></i> Registrar Nuevo Cliente
        </h3>
        <p style="color: var(--text-secondary); font-size: var(--font-size-sm); margin-bottom: var(--space-5);">
            Los datos se guardarán simultáneamente en las tablas 'usuarios' y 'clientes'.
        </p>

        <form action="index.php?controller=cliente&action=registrarCliente" method="POST">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: var(--space-4);">

                <div class="form-group">
                    <label>Nombre Completo</label>
                    <input type="text" name="nombre" placeholder="Ej. Juan Pérez" required>
                </div>

                <div class="form-group">
                    <label>Correo Electrónico</label>
                    <input type="email" name="correo" placeholder="juan@ejemplo.com" required>
                </div>

                <div class="form-group">
                    <label>Contraseña de Acceso</label>
                    <input type="password" name="contrasena" placeholder="Mínimo 6 caracteres" required>
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <input type="text" name="telefono" placeholder="Ej. 0999999999">
                </div>

                <div class="form-group">
                    <label>Género</label>
                    <select name="genero">
                        <option value="" selected disabled>Seleccione...</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento">
                </div>

                <div class="form-group" style="grid-column: span 1;">
                    <label>Dirección</label>
                    <input type="text" name="direccion" placeholder="Calle, Ciudad">
                </div>
            </div>

            <div class="form-group" style="margin-top: var(--space-4);">
                <label>Observaciones (Alergias, Tipo de Piel, etc.)</label>
                <textarea name="observaciones" rows="3" placeholder="Paciente con piel sensible, alérgica a ciertos aceites..."></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: var(--space-3); margin-top: var(--space-5); padding-top: var(--space-4); border-top: 1px solid var(--border-color);">
                <button type="button" class="btn btn-secondary" id="btnCancelarFormulario">Cancelar</button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Guardar Cliente
                </button>
            </div>
        </form>
    </div>

    <div class="card">
        <h3 class="card-title" style="font-size: var(--font-size-lg); margin-bottom: var(--space-5); display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-table"></i> Lista de Clientes Registrados
        </h3>

        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Género</th>
                        <th>Fecha Nacimiento</th>
                        <th>Dirección</th>
                        <th>Observaciones</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach ($clientes as $c): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($c->getNombre()) ?></strong></td>
                                <td><?= htmlspecialchars($c->getCorreo()) ?></td>
                                <td><?= htmlspecialchars($c->getTelefono() ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($c->getGenero() ?? 'No especificado') ?></td>
                                <td><?= htmlspecialchars($c->getFechaNacimiento() ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($c->getDireccion() ?? 'N/A') ?></td>
                                <td>
                                    <span style="color: var(--text-secondary); font-size: var(--font-size-xs);">
                                        <?= htmlspecialchars($c->getObservaciones() ?? 'Sin notas') ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div style="display: flex; gap: 8px; justify-content: center;">
                                        <a href="index.php?controller=cliente&action=editar&id=<?= $c->getIdCliente() ?>"
                                            class="btn"
                                            style="background: var(--color-warning); color: white; padding: 6px 12px; font-size: var(--font-size-sm);"
                                            title="Editar Cliente">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="index.php?controller=cliente&action=eliminar&id=<?= $c->getIdCliente() ?>"
                                            class="btn btn-danger"
                                            style="padding: 6px 12px; font-size: var(--font-size-sm);"
                                            onclick="return confirm('¿Estás seguro de que deseas desactivar este cliente?');"
                                            title="Eliminar Cliente">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center" style="padding: var(--space-6); color: var(--text-muted);">
                                No hay clientes registrados en el sistema actualmente.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
$pageScript = "assets/js/admin/cliente_crud.js";
require_once "views/layouts/footer.php";
?>