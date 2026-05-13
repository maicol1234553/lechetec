<?php

include("conexion.php");

if(isset($_POST['registrar'])){

    $usuario = $_POST['usuario'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $rol = $_POST['rol'];

    $numero = $_POST['numero_control'];

    $sql = "INSERT INTO usuarios 
    (usuario,password,rol,numero_control)

    VALUES

    ('$usuario','$password','$rol','$numero')";

    if($conn->query($sql)){

        echo "Usuario registrado";

    }else{

        echo "Error";
    }

}
?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Registrar Usuarios</title>

<link rel="stylesheet" href="../Css/usuarios.css">

</head>

<body>

<div class="contenedor">

<h1>Registrar Usuario</h1>

<form method="POST">

<input type="text"
name="usuario"
placeholder="Usuario"
required>

<input type="text"
name="numero_control"
placeholder="Número de control"
required>

<input type="password"
name="password"
placeholder="Contraseña"
required>

<select name="rol">

<option value="usuario">
Usuario
</option>

<option value="admin">
Administrador
</option>

</select>

<button type="submit"
name="registrar">

Registrar

</button>

</form>

</div>

</body>
</html>