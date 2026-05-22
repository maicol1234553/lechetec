<?php
session_start();

/* VALIDAR SESIÓN */
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

/* EVITAR CACHÉ */
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - Agro Data</title>
    <link rel="stylesheet" href="../Css/panel.css" />
    
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body>

<div class="layout">

    <div class="lado-imagen">
        <img src="../Img/imagen2.jpg" alt="Imagen lateral">

        <div class="usuario-overlay">
            <h1>
                Bienvenido, 
                <?php echo htmlspecialchars($_SESSION['usuario']); ?>
            </h1>
            <p>
                <?php echo ($_SESSION['rol'] == 'admin') ? 'Administrador' : 'Usuario'; ?>
            </p>
        </div>
    </div>

    <div class="contenido">

        <section class="principal">
            <div class="card">

                <div class="titulo-panel">
                    <div class="header-panel">
                        <img src="../Img/escudo_tecnologico-removebg-preview.png" class="logo-panel" alt="Escudo">
                        
                        <div>
                            <h2>Panel principal</h2>
                            <p>Gestiona la información y registros del sistema</p>
                        </div>
                    </div>
                </div>

                <nav class="opciones-panel">

                    <a href="../Html/menu.html" class="boton-panel">
                        <div class="contenedor-icono-texto">
                            <i data-lucide="test-tube-2" class="icono-menu"></i>
                            <span>Registrar análisis</span>
                        </div>
                        <i data-lucide="chevron-right" class="icono-flecha"></i>
                    </a>

                    <a href="ver_usuarios.php" class="boton-panel">
                        <div class="contenedor-icono-texto">
                            <i data-lucide="folder-open" class="icono-menu"></i>
                            <span>Ver registros</span>
                        </div>
                        <i data-lucide="chevron-right" class="icono-flecha"></i>
                    </a>

                    <?php if ($_SESSION['rol'] == 'admin'): ?>

                        <a href="registro_usuario.php" class="boton-panel">
                            <div class="contenedor-icono-texto">
                                <i data-lucide="user-plus" class="icono-menu"></i>
                                <span>Registrar usuarios</span>
                            </div>
                            <i data-lucide="chevron-right" class="icono-flecha"></i>
                        </a>

                        <a href="../Html/reportes.html" class="boton-panel">
                            <div class="contenedor-icono-texto">
                                <i data-lucide="file-bar-chart-2" class="icono-menu"></i>
                                <span>Reportes e informes</span>
                            </div>
                            <i data-lucide="chevron-right" class="icono-flecha"></i>
                        </a>

                    <?php endif; ?>

                </</nav>

            </div>
        </section>

    </div>

</div>

<script>
    // Inicialización de los íconos vectoriales SVG
    lucide.createIcons();

    // Gestión del estado del menú desplegable
    function toggleMenu() {
        const menu = document.getElementById("menuDropdown");
        menu.classList.toggle("active");
    }

    // Cierre adaptativo del menú al interactuar fuera del elemento
    document.addEventListener("click", function(e) {
        const menu = document.getElementById("menuDropdown");
        const boton = document.querySelector(".menu");

        if (menu && boton && !boton.contains(e.target) && !menu.contains(e.target)) {
            menu.classList.remove("active");
        }
    </script>

</body>
</html>