<?php
include("conexion.php");
date_default_timezone_set('America/Mexico_City');

// 1. Capturar filtros
$tipo_filtro = $_POST['tipo_filtro'] ?? 'dia';
$fecha_inicio = $_POST['fecha_inicio'] ?? date("Y-m-d");
$fecha_fin = $_POST['fecha_fin'] ?? '';
$accion = $_POST['accion'] ?? 'ver';

// 2. Condición dinámica
if ($tipo_filtro == 'rango' && !empty($fecha_fin)) {
    $condicion = "m.FEC_MUE BETWEEN '$fecha_inicio' AND '$fecha_fin'";
    $titulo_reporte = "Período: $fecha_inicio al $fecha_fin";
} else {
    $condicion = "m.FEC_MUE = '$fecha_inicio'";
    $titulo_reporte = "Día: $fecha_inicio";
}

// 3. CONSULTA PROFESIONAL (JOIN usuarios)
$sql = "SELECT 
    m.ID_MUE, m.FEC_MUE, m.HOR_MUE, m.ORI_MUE, m.RES_MUE,
    u.usuario, u.numero_control,
    f.ACI_AFQ, f.DEN_AFQ, f.GRA_AFQ, f.PH_AFQ, f.ALC_AFQ, f.PRO_AFQ, f.FOS_AFQ,
    mic.COL_MIC, mic.MES_MIC, mic.SAL_MIC, mic.OBS_MIC

FROM MUESTRA m
INNER JOIN usuarios u ON m.id_usuario = u.id
INNER JOIN ANALISIS_FQ f ON m.ID_MUE = f.ID_MUE
INNER JOIN ANALISIS_MICRO mic ON m.ID_MUE = mic.ID_MUE

WHERE $condicion
ORDER BY m.FEC_MUE DESC, m.HOR_MUE DESC";

$resultado = $conn->query($sql);

// 4. Exportar Excel
if ($accion == "excel") {
    header("Content-Type: application/vnd.ms-excel; charset=iso-8859-1");
    header("Content-Disposition: attachment; filename=Reporte_Leche.xls");
    header("Pragma: no-cache");
    header("Expires: 0");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Informe - <?php echo $titulo_reporte; ?></title>

<style>
body { font-family: Arial, sans-serif; color: #333; padding: 20px; }

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
    background: white;
}

th {
    background-color: #6b1d1d;
    color: white;
    padding: 10px;
    font-size: 13px;
    text-align: center;
}

td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: center;
    font-size: 12px;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

.no-print {
    display: inline-block;
    margin-bottom: 20px;
    text-decoration: none;
    color: #6b1d1d;
    font-weight: bold;
    border: 1px solid #6b1d1d;
    padding: 5px 10px;
    border-radius: 4px;
}

/* estilos visuales */
.positivo { color: #d9534f; font-weight: bold; }
.negativo { color: #5cb85c; }

.usuario {
    font-weight: bold;
    color: #333;
}

.control {
    font-size: 11px;
    color: #777;
}
</style>
</head>

<body>

<h2>Informe de Análisis de Leche: <?php echo $titulo_reporte; ?></h2>

<?php if($accion == "ver"): ?>
<a href="../Html/reportes.html" class="no-print">← Volver al Panel</a>
<?php endif; ?>

<table>
<thead>
<tr>
    <th>ID</th>
    <th>Fecha</th>
    <th>Hora</th>
    <th>Origen</th>
    <th>Responsable</th>
    <th>Registrado por</th>
    <th>Acidez</th>
    <th>Densidad</th>
    <th>Grasa</th>
    <th>pH</th>
    <th>Alcohol</th>
    <th>Proteína</th>
    <th>Fosfatasa</th>
    <th>Micro (C | M | S)</th>
    <th>Observaciones</th>
</tr>
</thead>

<tbody>
<?php 
if ($resultado && $resultado->num_rows > 0) {

    while($row = $resultado->fetch_assoc()) {

        $col = ($row['COL_MIC'] == 1) ? "<span class='positivo'>POS</span>" : "<span class='negativo'>NEG</span>";
        $mes = ($row['MES_MIC'] == 1) ? "<span class='positivo'>POS</span>" : "<span class='negativo'>NEG</span>";
        $sal = ($row['SAL_MIC'] == 1) ? "<span class='positivo'>POS</span>" : "<span class='negativo'>NEG</span>";

        echo "<tr>
            <td>{$row['ID_MUE']}</td>
            <td>{$row['FEC_MUE']}</td>
            <td>{$row['HOR_MUE']}</td>
            <td>{$row['ORI_MUE']}</td>
            <td>{$row['RES_MUE']}</td>

            <td>
                <div class='usuario'>{$row['usuario']}</div>
                <div class='control'>{$row['numero_control']}</div>
            </td>

            <td>{$row['ACI_AFQ']}</td>
            <td>{$row['DEN_AFQ']}</td>
            <td>{$row['GRA_AFQ']}</td>
            <td>{$row['PH_AFQ']}</td>
            <td>{$row['ALC_AFQ']}</td>
            <td>{$row['PRO_AFQ']}</td>
            <td>{$row['FOS_AFQ']}</td>
            <td>$col | $mes | $sal</td>
            <td>{$row['OBS_MIC']}</td>
        </tr>";
    }

} else {
    echo "<tr><td colspan='15'>No se encontraron registros para el criterio seleccionado.</td></tr>";
}
?>
</tbody>
</table>

</body>
</html>

<?php $conn->close(); ?>