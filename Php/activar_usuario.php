<?php

include("conexion.php");

$id = $_GET['id'];

$sql = "UPDATE usuarios

SET estado='activo'

WHERE id='$id'";

$conn->query($sql);

header("Location: ver_usuarios.php");

?>
