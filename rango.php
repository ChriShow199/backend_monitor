<?php
include 'conexion.php';
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$inicio = $_GET['inicio'] ?? '';
$fin = $_GET['fin'] ?? '';

try {
    $pdo = new Conexion();
    $sql = $pdo->prepare("SELECT uso_cpu, uso_memoria, uso_disco, uso_gpu, fecha_hora 
                      FROM rendimiento 
                      WHERE fecha_hora BETWEEN :inicio AND :fin 
                      ORDER BY fecha_hora ASC");
    $sql->execute([':inicio' => $inicio, ':fin' => $fin]);
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>