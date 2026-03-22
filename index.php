<?  
$conn = new mysqli("localhost:8080", "root", "", "parametros");
$resultado = $conn->query("SELECT * FROM rendimiento ORDER BY fecha DESC LIMIT 10");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Monitor de Sistema</title>
</head>
<body>
    <h2>Últimos Registros de Rendimiento</h2>
    <table border="1">
        <tr>
            <th>Fecha</th><th>CPU (%)</th><th>RAM (%)</th><th>Disco (%)</th><th>GPU (%)</th><th>VRAM (%)</th>
        </tr>
        <?php while ($fila = $resultado->fetch_assoc()) { ?>
        <tr>
            <td><?= $fila["cpu"] ?></td>
            <td><?= $fila["ram"] ?></td>
            <td><?= $fila["disco"] ?></td>
            <td><?= $fila["gpu"] ?></td>
            <td><?= $fila["vram"] ?></td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
