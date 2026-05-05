<?php
// Proyecto/Php/guardar_leche.php actualizado para 7 datos FQ y validación required
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: ../login.php");
    exit();
}
include("conexion.php");

// 1. Recibir datos generales
$origen      = $_POST['origen'] ?? '';
$responsable = $_POST['responsable'] ?? '';
// ... resto de tu código ...

// Ahora estas variables tomarán la hora de Ciudad de México
// Método alternativo usando objetos de fecha
$zona_horaria = new DateTimeZone('America/Mexico_City');
$fecha_objeto = new DateTime('now', $zona_horaria);

$fecha = $fecha_objeto->format("Y-m-d");
$hora  = $fecha_objeto->format("H:i:s");

// 2. Fisicoquímicos (Capturando los 7 datos del formulario)
// Las validaciones 'required' del HTML aseguran que estos datos lleguen.
$acidez     = $_POST['acidez'];
$alcohol    = $_POST['alcohol']; // Dato nuevo
$proteina   = $_POST['proteina']; // Dato nuevo
$densidad   = $_POST['densidad'];
$grasa      = $_POST['grasa'];
$ph         = $_POST['ph'];
$fosfatasa  = $_POST['fosfatasa']; // Dato nuevo

// 3. Microbiológicos (Usando la lógica de 1/0 corregida anteriormente)
$coliformes = isset($_POST['coliformes']) ? 1 : 0;
$mesofilos  = isset($_POST['mesofilos']) ? 1 : 0;
$salmonella = isset($_POST['salmonella']) ? 1 : 0;
$observaciones = $_POST['observaciones'] ?? '';
$ufc_mic = 0; // UFC por defecto si no hay campo

// --- 1️⃣ INSERTAR EN TABLA MUESTRA ---
$sql_muestra = "INSERT INTO MUESTRA (FEC_MUE, HOR_MUE, ORI_MUE, RES_MUE) 
                VALUES ('$fecha', '$hora', '$origen', '$responsable')";

if ($conn->query($sql_muestra) === TRUE) {
    $id_generado = $conn->insert_id; 

    // --- 2️⃣ INSERTAR EN ANALISIS_FQ (Actualizado para las 7 columnas) ---
    $sql_fq = "INSERT INTO ANALISIS_FQ (ID_MUE, ACI_AFQ, DEN_AFQ, GRA_AFQ, PH_AFQ, ALC_AFQ, PRO_AFQ, FOS_AFQ) 
               VALUES ('$id_generado', '$acidez', '$densidad', '$grasa', '$ph', '$alcohol', '$proteina', '$fosfatasa')";
    if (!$conn->query($sql_fq)) {
        echo "Error en Fisicoquímico: " . $conn->error . "<br>";
    }

    // --- 3️⃣ INSERTAR EN ANALISIS_MICRO (Incluyendo Mesófilos y Salmonella, ver corrección anterior) ---
    // Asegúrate de que tu base de datos ya tiene MES_MIC y SAL_MIC antes de usar este INSERT.
    $sql_micro = "INSERT INTO ANALISIS_MICRO (ID_MUE, UFC_MIC, COL_MIC, MES_MIC, SAL_MIC, OBS_MIC) 
                  VALUES ('$id_generado', '$ufc_mic', '$coliformes', '$mesofilos', '$salmonella', '$observaciones')";
    if (!$conn->query($sql_micro)) {
        echo "Error en Microbiológico: " . $conn->error . "<br>";
    }

    // ✅ ÉXITO Y RETORNO
    echo "<script>
            alert('¡Registro guardado correctamente!');
            window.location.href='../Html/lechetec.html'; 
          </script>";
} else {
    echo "Error en Muestra: " . $conn->error;
}

$conn->close();
?>