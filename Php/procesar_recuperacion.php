<?php

include("conexion.php");

$usuario = $_POST['usuario'];
$numero_control = $_POST['numero_control'];
$nueva_password = $_POST['nueva_password'];

$sql = "SELECT * FROM usuarios
        WHERE usuario = ?
        AND numero_control = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $numero_control);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows > 0){

    $hash = password_hash($nueva_password, PASSWORD_DEFAULT);

    $update = $conn->prepare(
        "UPDATE usuarios
         SET password = ?
         WHERE usuario = ?"
    );

    $update->bind_param("ss", $hash, $usuario);

    if($update->execute()){

        echo "Contraseña actualizada correctamente";

    }else{

        echo "Error al actualizar";

    }

}else{

    echo "Usuario o número de control incorrectos";

}

?>