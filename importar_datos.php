<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'conexion.php';

try {
    $pdo = new Conexion();

    $sql = $pdo->prepare("SELECT fecha_hora FROM rendimiento ORDER BY fecha_hora ASC");
    $sql->execute();

    $fechas = $sql->fetchAll(PDO::FETCH_COLUMN); // Solo devuelve el campo `fecha_hora`

    echo json_encode($fechas);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
