<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Agro Data</title>

    <link rel="stylesheet" href="../Css/estilos.css" />
    <link rel="stylesheet" href="../Css/index.css" />
    <link rel="stylesheet" href="../Css/login.css" />
</head>
<body>

<section class="principal">
    <img src="../Img/Logo_Fond_Trans-removebg-preview.png" class="logo" alt="Logo Agro Data" />
    
    <h2>Iniciar Sesión</h2>
    <p class="universidad">Laboratorio de análisis de leche</p>

    <!-- MENSAJE DE ERROR -->
    <?php if (isset($_GET['error'])): ?>
        <div class="error-mensaje">
            Usuario o contraseña incorrectos
        </div>
    <?php endif; ?>

    <form action="../Php/validar_login.php" method="POST" class="form-login">
        <input type="text" name="usuario" placeholder="Usuario" required class="input">
        <input type="password" name="password" placeholder="Contraseña" required class="input">
        
        <button type="submit" class="boton">
            Entrar
        </button>
    </form>
</section>

</body>
</html>