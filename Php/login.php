<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Login - Agro Data</title>
    <link rel="stylesheet" href="../Css/estilos.css" />
    <link rel="stylesheet" href="../Css/index.css" />
</head>

<body>

<header>
    <div class="menu-container">
    </div>
</header>

<section class="principal">
    <img src="../Img/Logo_Fond_Trans-removebg-preview.png" class="logo" />
    
    <h2>Iniciar Sesión</h2>
    <p class="universidad">Laboratorio de análisis de leche</p>

    <!--  MENSAJE DE ERROR -->
    <?php if (isset($_GET['error'])) { ?>
        <p style="color:red; margin:10px;">
            Usuario o contraseña incorrectos
        </p>
    <?php } ?>

    <!-- FORMULARIO -->
    <form action="../Php/validar_login.php" method="POST">

        <input type="text" name="usuario" placeholder="Usuario" required class="input"><br>

        <input type="password" name="password" placeholder="Contraseña" required class="input"><br>

        <button type="submit" class="boton">
            Entrar
        </button>

    </form>

</section>

<script>
function toggleMenu(){
    document.getElementById("menuDropdown").classList.toggle("activo");
}
</script>

</body>
</html>