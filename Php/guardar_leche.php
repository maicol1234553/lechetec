<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}

include("conexion.php");

// 🔥 IMPORTANTE
$id_usuario = $_SESSION['id']; // 👈 AQUÍ TOMAS EL ID

// 1. Datos generales
$origen      = $_POST['origen'] ?? '';
$responsable = $_POST['responsable'] ?? '';

// Fecha y hora México
$zona_horaria = new DateTimeZone('America/Mexico_City');
$fecha_objeto = new DateTime('now', $zona_horaria);

$fecha = $fecha_objeto->format("Y-m-d");
$hora  = $fecha_objeto->format("H:i:s");

// 2. FQ
$acidez     = $_POST['acidez'];
$alcohol    = $_POST['alcohol'];
$proteina   = $_POST['proteina'];
$densidad   = $_POST['densidad'];
$grasa      = $_POST['grasa'];
$ph         = $_POST['ph'];
$fosfatasa  = $_POST['fosfatasa'];

// 3. Micro
$coliformes = isset($_POST['coliformes']) ? 1 : 0;
$mesofilos  = isset($_POST['mesofilos']) ? 1 : 0;
$salmonella = isset($_POST['salmonella']) ? 1 : 0;
$observaciones = $_POST['observaciones'] ?? '';
$ufc_mic = 0;

// 🔥 1️⃣ INSERTAR MUESTRA (CORREGIDO)
$sql_muestra = "INSERT INTO MUESTRA 
(FEC_MUE, HOR_MUE, ORI_MUE, RES_MUE, id_usuario) 
VALUES 
('$fecha', '$hora', '$origen', '$responsable', '$id_usuario')";

if ($conn->query($sql_muestra) === TRUE) {

    $id_generado = $conn->insert_id;

    // 🔥 2️⃣ FQ
    $sql_fq = "INSERT INTO ANALISIS_FQ 
    (ID_MUE, ACI_AFQ, DEN_AFQ, GRA_AFQ, PH_AFQ, ALC_AFQ, PRO_AFQ, FOS_AFQ) 
    VALUES 
    ('$id_generado', '$acidez', '$densidad', '$grasa', '$ph', '$alcohol', '$proteina', '$fosfatasa')";

    if (!$conn->query($sql_fq)) {
        echo "Error FQ: " . $conn->error;
    }

    // 🔥 3️⃣ MICRO
    $sql_micro = "INSERT INTO ANALISIS_MICRO 
    (ID_MUE, UFC_MIC, COL_MIC, MES_MIC, SAL_MIC, OBS_MIC) 
    VALUES 
    ('$id_generado', '$ufc_mic', '$coliformes', '$mesofilos', '$salmonella', '$observaciones')";

    if (!$conn->query($sql_micro)) {
        echo "Error MICRO: " . $conn->error;
    }

    // ✅ OK
    echo "<script>
            alert('¡Registro guardado correctamente!');
            window.location.href='../Html/lechetec.html';
          </script>";

} else {
    echo "Error en MUESTRA: " . $conn->error;
}

$conn->close();
?>