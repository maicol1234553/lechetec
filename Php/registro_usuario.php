<?php

include("conexion.php");

if(isset($_POST['registrar'])){

    $usuario = $_POST['usuario'];

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $rol = $_POST['rol'];

    $numero = $_POST['numero_control'];

    $frase_secreta = $_POST['frase_secreta'];

    $sql = "INSERT INTO usuarios
    (usuario,password,rol,numero_control,frase_secreta)

    VALUES

    ('$usuario','$password','$rol','$numero','$frase_secreta')";

    if($conn->query($sql)){

        echo "Usuario registrado correctamente";

    }else{

        echo "Error: " . $conn->error;
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

<input
type="text"
name="frase_secreta"
placeholder="Frase secreta"
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