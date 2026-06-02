<?php

include("conexion.php");

$id = (int) $_GET['id'];

$sql = "SELECT * FROM usuarios WHERE id='$id'";

$resultado = $conn->query($sql);

$fila = $resultado->fetch_assoc();

if(isset($_POST['actualizar'])){

    $usuario = $_POST['usuario'];
    $numero = $_POST['numero_control'];
    $rol = $_POST['rol'];
    $password = $_POST['password'];

    // Si escribió una nueva contraseña
    if(!empty($password)){

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $sqlUpdate = "UPDATE usuarios SET
            usuario='$usuario',
            numero_control='$numero',
            rol='$rol',
            password='$passwordHash'
            WHERE id='$id'";

    }else{

        // Si no escribió contraseña, no se modifica
        $sqlUpdate = "UPDATE usuarios SET
            usuario='$usuario',
            numero_control='$numero',
            rol='$rol'
            WHERE id='$id'";
    }

    if($conn->query($sqlUpdate)){

        header("Location: ver_usuarios.php");
        exit();

    }else{

        echo "Error al actualizar: " . $conn->error;

    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Editar Usuario</title>

    <link rel="stylesheet" href="../Css/usuarios.css">

</head>

<body>

<div class="contenedor">

    <h1>Editar Usuario</h1>

    <form method="POST">

        <input
            type="text"
            name="usuario"
            value="<?php echo $fila['usuario']; ?>"
            required>

        <input
            type="text"
            name="numero_control"
            value="<?php echo $fila['numero_control']; ?>"
            required>

        <select name="rol" required>

            <option value="usuario"
                <?php if($fila['rol'] == 'usuario') echo 'selected'; ?>>
                Usuario
            </option>

            <option value="admin"
                <?php if($fila['rol'] == 'admin') echo 'selected'; ?>>
                Administrador
            </option>

        </select>

        <input
            type="password"
            name="password"
            placeholder="Nueva contraseña (opcional)">

        <button
            type="submit"
            name="actualizar">

            Actualizar

        </button>

    </form>

</div>

</body>
</html>