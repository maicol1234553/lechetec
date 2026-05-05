<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - Agro Data</title>

    <link rel="stylesheet" href="../Css/panel.css" />
</head>

<body>

<div class="layout">

    <!-- 🔹 LADO IZQUIERDO (IMAGEN GRANDE) -->
    <div class="lado-imagen">
        <img src="../Img/imagen2.jpg" alt="Imagen lateral">
    </div>

    <!-- 🔹 LADO DERECHO (CONTENIDO) -->
    <div class="contenido">

        <!-- 🔥 HEADER CON MENÚ FUNCIONAL -->
        <header>
            
            <div class="menu-container">

                <div class="menu" onclick="toggleMenu()">&#9776;</div>

                <div class="dropdown" id="menuDropdown">

                    <div class="menu-section">
                        <a href="quienes_somos.php" class="menu-link">¿Quiénes somos?</a>
                        <p>
                            Agro Data es una plataforma enfocada en el análisis y control 
                            de calidad de la leche, facilitando la gestión de datos en laboratorios.
                        </p>
                    </div>

                    <div class="menu-section">
                        <a href="para_quien.php" class="menu-link">¿Para quién va dirigido?</a>
                        <p>
                            Dirigido a estudiantes, laboratoristas y profesionales del sector 
                            agroindustrial que necesitan registrar y analizar información.
                        </p>
                    </div>

                </div>

            </div>
        </header>

        <!-- 🔹 CONTENIDO PRINCIPAL -->
        <section class="principal">
            <div class="card">

                <img src="../Img/Logo_Fond_Trans-removebg-preview.png" class="logo" />

                <h2>
                    Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>
                </h2>

                <p class="universidad">
                    <?php echo ($_SESSION['rol'] == 'admin') ? 'Panel de Administrador' : 'Panel de Usuario'; ?>
                </p>

                <nav class="opciones-panel">
                    <a href="../Html/lechetec.html" class="boton-panel">Registrar análisis</a>
                    <a href="ver_registros.php" class="boton-panel">Ver registros</a>

                    <?php if ($_SESSION['rol'] == 'admin'): ?>
                        <a href="../Html/menu.html" class="boton-panel">Hacer registro de alimentos</a>
                        <a href="registro_usuario.php" class="boton-panel">Registrar usuarios</a>
                        <a href="../Html/reportes.html" class="boton-panel">Reportes e informes </a>
                    <?php endif; ?>
                </nav>

            </div>
        </section>
       
    </div>
</div>

<!-- 🔥 JAVASCRIPT FUNCIONAL -->
<script>
function toggleMenu() {
    const menu = document.getElementById("menuDropdown");
    menu.classList.toggle("active");
}

document.addEventListener("click", function(e) {
    const menu = document.getElementById("menuDropdown");
    const boton = document.querySelector(".menu");

    if (!boton.contains(e.target) && !menu.contains(e.target)) {
        menu.classList.remove("active");
    }
});
</script>

</body>
</html>