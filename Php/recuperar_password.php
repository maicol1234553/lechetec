<?php

include("conexion.php");

$mensaje = "";
$tipoMensaje = "";

if(isset($_POST['recuperar'])){

    $usuario = $_POST['usuario'];
    $numero = $_POST['numero_control'];
    $frase = $_POST['frase_secreta'];
    $nueva = $_POST['nueva_password'];

    $sql = "SELECT * FROM usuarios
            WHERE usuario='$usuario'
            AND numero_control='$numero'";

    $resultado = $conn->query($sql);

    if($resultado->num_rows > 0){

        $fila = $resultado->fetch_assoc();

        if(
            strtolower(trim($frase))
            ==
            strtolower(trim($fila['frase_secreta']))
        ){

            $passwordHash = password_hash(
                $nueva,
                PASSWORD_DEFAULT
            );

            $update = "UPDATE usuarios
                       SET password='$passwordHash'
                       WHERE usuario='$usuario'";

            if($conn->query($update)){

                $mensaje = "Contraseña actualizada correctamente";
                $tipoMensaje = "success";

            }else{

                $mensaje = "Error al actualizar la contraseña";
                $tipoMensaje = "error";
            }

        }else{

            $mensaje = "Frase secreta incorrecta";
            $tipoMensaje = "error";
        }

    }else{

        $mensaje = "Usuario o número de control incorrectos";
        $tipoMensaje = "error";
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Recuperar Contraseña</title>

    <link rel="stylesheet"
          href="../Css/recuperar_password.css">

</head>

<body>

<div class="contenedor">

    <h2>Recuperar Contraseña</h2>

    <form action="" method="POST">

        <input
            type="text"
            name="usuario"
            placeholder="Usuario"
            required>

        <input
            type="text"
            name="numero_control"
            placeholder="Número de Control"
            required>

        <input
            type="text"
            name="frase_secreta"
            placeholder="Frase secreta"
            required>

        <input
            type="password"
            name="nueva_password"
            placeholder="Nueva Contraseña"
            required>

        <button
            type="submit"
            name="recuperar">

            Cambiar Contraseña

        </button>

    </form>

    <?php if(!empty($mensaje)){ ?>

        <div class="<?php echo $tipoMensaje; ?>">

            <?php echo $mensaje; ?>

        </div>

    <?php } ?>

    <a href="login.php" class="volver">
        ← Volver al Login
    </a>

</div>

</body>
</html>