<footer class="footer">
    <p>&copy; <?= date('Y'); ?> Spa & Belleza | Panel Administrativo</p>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>

<?php
// Imprimimos el script directamente si la variable fue declarada en la vista
if (isset($pageScript)) {
    echo '<script src="' . htmlspecialchars($pageScript) . '"></script>';
}
?>
</body>
</html>