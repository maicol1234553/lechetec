<?php
session_start();

// PROTEGER ACCESO
if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Panel - Agro Data</title>
    <link rel="stylesheet" href="../Css/estilos.css" />
    <link rel="stylesheet" href="../Css/index.css" />
</head>

<body>

<header>
    <div class="menu-container">
        <div class="menu" onclick="toggleMenu()">&#9776;</div>
        <div class="dropdown" id="menuDropdown">
            <a href="../Html/index.html">¿Que es AgroData?</a>
            <a href="../Html/menu.html">Que se registra</a>
            <a href="logout.php">Cerrar sesión</a>
        </div>
    </div>
</header>

<section class="principal">
    <img src="../Img/Logo_Fond_Trans-removebg-preview.png" class="logo" />
    
    <!--  USUARIO -->
    <h2>Bienvenido <?php echo $_SESSION['usuario']; ?></h2>

    <!--  ROL -->
    <?php if ($_SESSION['rol'] == 'admin') { ?>
        <p class="universidad">Panel de Administrador</p>
    <?php } else { ?>
        <p class="universidad">Panel de Usuario</p>
    <?php } ?>

    <!--  OPCIONES -->
    <div style="margin-top:20px;">

        <a href="../Html/lechetec.html" class="boton">
            Registrar análisis
        </a><br><br>

        <a href="ver_registros.php" class="boton">
            Ver registros
        </a><br><br>

        <!-- SOLO ADMIN -->
        <?php if ($_SESSION['rol'] == 'admin') { ?>
            <a href="../Html/menu.html" class="boton">
                Hacer registro de alimentos
            </a><br><br>

            <a href="registro_usuario.php" class="boton">
                Registrar usuarios
            </a>
        <?php } ?>

    </div>

</section>

<script>
function toggleMenu(){
    document.getElementById("menuDropdown").classList.toggle("activo");
}
</script>

</body>
</html>