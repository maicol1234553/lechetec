<?php

session_start();

include("conexion.php");

/* EVITAR CACHE */

header("Cache-Control: no-cache, no-store, must-revalidate");

header("Pragma: no-cache");

header("Expires: 0");

/* DATOS DEL FORMULARIO */

$usuario = $_POST['usuario'];

$password = $_POST['password'];

/* CONSULTA */

$sql = "SELECT * FROM usuarios
        WHERE usuario = '$usuario'
        AND estado = 'activo'";

$result = $conn->query($sql);

/* VALIDAR USUARIO */

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    /* VALIDAR CONTRASEÑA */

    if (password_verify($password, $row['password'])) {

        /* REGENERAR SESION */
        session_regenerate_id(true);

        /* GUARDAR SESION */

        $_SESSION['id'] = $row['id'];

        $_SESSION['usuario'] = $row['usuario'];

        $_SESSION['rol'] = $row['rol'];

        /* REDIRECCION */

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