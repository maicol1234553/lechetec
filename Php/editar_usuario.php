<?php

include("conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM usuarios WHERE id='$id'";

$resultado = $conn->query($sql);

$fila = $resultado->fetch_assoc();

if(isset($_POST['actualizar'])){

    $usuario = $_POST['usuario'];

    $numero = $_POST['numero_control'];

    $rol = $_POST['rol'];

    $sqlUpdate = "UPDATE usuarios SET

    usuario='$usuario',

    numero_control='$numero',

    rol='$rol'

    WHERE id='$id'";

    if($conn->query($sqlUpdate)){

        header("Location: ver_usuarios.php");
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

<input type="text"
name="usuario"
value="<?php echo $fila['usuario']; ?>">

<input type="text"
name="numero_control"
value="<?php echo $fila['numero_control']; ?>">

<select name="rol">

<option value="usuario">

Usuario

</option>

<option value="admin">

Administrador

</option>

</select>

<button type="submit"
name="actualizar">

Actualizar

</button>

</form>

</div>

</body>
</html>