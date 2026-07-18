<footer class="footer">
    <p>&copy; <?= date('Y'); ?> Delux Spa. Todos los derechos reservados.</p>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php

// Imprimimos el script directamente si la variable fue declarada en la vista

if (!empty($pageScript)) {
    $scripts = is_array($pageScript) ? $pageScript : [$pageScript];

    foreach ($scripts as $script) {
        echo '<script src="' . htmlspecialchars($script, ENT_QUOTES, 'UTF-8') . '"></script>';
    }
}
?>

</body>
</html>