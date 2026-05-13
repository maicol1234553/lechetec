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

    <!-- 🔹 LADO IZQUIERDO -->
    <div class="lado-imagen">

        <img src="../Img/imagen2.jpg" alt="Imagen lateral">

        <!-- TEXTO SOBRE IMAGEN -->
        <div class="usuario-overlay">

            <h1>
                Bienvenido,
                <?php echo htmlspecialchars($_SESSION['usuario']); ?>
            </h1>

            <p>
                <?php echo ($_SESSION['rol'] == 'admin')
                ? 'Administrador'
                : 'Usuario'; ?>
            </p>

        </div>

    </div>

    <!-- 🔹 CONTENIDO DERECHO -->
    <div class="contenido">

        <!-- 🔹 HEADER -->
        <header>

            <div class="menu-container">

                <!-- BOTON MENU -->
                <div class="menu" onclick="toggleMenu()">
                    &#9776;
                </div>

                <!-- MENU DESPLEGABLE -->
                <div class="dropdown" id="menuDropdown">

                    <a href="quienes_somos.php">
                        ¿Quiénes somos?
                    </a>

                    <a href="para_quien.php">
                        ¿Para quién va dirigido?
                    </a>

                </div>

            </div>

        </header>

        <!-- 🔹 PANEL PRINCIPAL -->
        <section class="principal">

            <div class="card">

                <!-- HEADER PANEL -->
                <div class="titulo-panel">

                    <div class="header-panel">

                        <!-- ESCUDO -->
                        <img 
                        src="../Img/escudo_tecnologico-removebg-preview.png"
                        class="logo-panel"
                        alt="Escudo">

                        <!-- TEXTO -->
                        <div>

                            <h2>Panel principal</h2>

                            <p>
                                Gestiona la información y registros del sistema
                            </p>

                        </div>

                    </div>

                </div>

                <!-- 🔹 BOTONES -->
                <nav class="opciones-panel">

                    <a href="../Html/menu.html" class="boton-panel">

                        <span>📋 Registrar análisis</span>

                        <span>›</span>

                    </a>

                    <a href="ver_usuarios.php" class="boton-panel">

                        <span>📁 Ver registros</span>

                        <span>›</span>

                    </a>

                    <?php if ($_SESSION['rol'] == 'admin'): ?>

                    <a href="registro_usuario.php" class="boton-panel">

                        <span>👤 Registrar usuarios</span>

                        <span>›</span>

                    </a>

                    <a href="../Html/reportes.html" class="boton-panel">

                        <span>📊 Reportes e informes</span>

                        <span>›</span>

                    </a>

                    <?php endif; ?>

                </nav>

            </div>

        </section>

    </div>

</div>

<!-- 🔹 JAVASCRIPT -->
<script>

function toggleMenu() {

    const menu = document.getElementById("menuDropdown");

    menu.classList.toggle("active");
}

/* CERRAR MENU SI SE DA CLICK AFUERA */
document.addEventListener("click", function(e) {

    const menu = document.getElementById("menuDropdown");

    const boton = document.querySelector(".menu");

    if (
        !boton.contains(e.target) &&
        !menu.contains(e.target)
    ) {
        menu.classList.remove("active");
    }

});

</script>

</body>
</html>