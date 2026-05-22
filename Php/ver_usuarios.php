<?php

include("conexion.php");

$sql = "SELECT * FROM usuarios";
$resultado = $conn->query($sql);

if(!$resultado){
    die("Error en la consulta: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>

    <link rel="stylesheet" href="../Css/ver_usuarios.css">

</head>
<body>

<div class="contenedor">

    <h1>Usuarios Registrados</h1>

    <table>

        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Número</th>
            <th>Rol</th>
            <th>Estado</th>
            <th>Editar</th>
            <th>Acción</th>
        </tr>

        <?php while($fila = $resultado->fetch_assoc()){ ?>

        <tr>

            <td><?php echo $fila['id']; ?></td>

            <td><?php echo $fila['usuario']; ?></td>

            <td><?php echo $fila['numero_control']; ?></td>

            <td><?php echo $fila['rol']; ?></td>

            <td>

            <?php

            if($fila['estado'] == 'activo'){

                echo "<span class='activo'>🟢 Activo</span>";

            }else{

                echo "<span class='inactivo'>🔴 Inactivo</span>";
            }

            ?>

            </td>

            <td>

                <a class="editar"
                href="editar_usuario.php?id=<?php echo $fila['id']; ?>">

                Editar

                </a>

            </td>

            <td>

            <?php if($fila['estado'] == 'activo'){ ?>

                <a class="desactivar"
                href="desactivar_usuario.php?id=<?php echo $fila['id']; ?>">

                Desactivar

                </a>

            <?php }else{ ?>

                <a class="activar"
                href="activar_usuario.php?id=<?php echo $fila['id']; ?>">

                Activar

                </a>

            <?php } ?>

            </td>

        </tr>

        <?php } ?>

    </table>

</div>

</body>
</html>