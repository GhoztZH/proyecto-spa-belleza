<footer class="footer">
    <p>&copy; <?= date('Y'); ?> Spa & Belleza | Panel Cliente</p>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/js/all.min.js"></script>
<script src="/proyecto_segunda_huella/assets/js/registroCita.js"></script>
<script src="/proyecto_segunda_huella/assets/js/cita.js"></script>

<?php
if (isset($pageScript) && file_exists($pageScript)) {
    echo '<script src="' . $pageScript . '"></script>';
}
?>
</body>

</html>