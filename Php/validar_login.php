<?php

session_start();

include("conexion.php");

$usuario = $_POST['usuario'];

$password = $_POST['password'];

$sql = "SELECT * FROM usuarios 

WHERE usuario = '$usuario'

AND estado = 'activo'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    if (password_verify($password, $row['password'])) {

        // 🔥 GUARDAR SESION
        $_SESSION['id'] = $row['id'];

        $_SESSION['usuario'] = $row['usuario'];

        $_SESSION['rol'] = $row['rol'];

        header("Location: panel.php");

        exit();

    } else {

        header("Location: login.php?error=1");

        exit();
    }

} else {

    header("Location: login.php?error=1");

    exit();
}

?>