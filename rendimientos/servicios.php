<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'insertar_ejecucion.php';

$servicio = $_GET['servicio'] ?? null;

$ejecucion = new Inyectar_Ejecutar();

switch ($servicio) 
{
    case 'cpu':
        $ejecucion->Ejecutar('uso_cpu');
        break;

    case 'memoria':
        $ejecucion->Ejecutar('uso_memoria');
        break;

    case 'disco':
        $ejecucion->Ejecutar('uso_disco');
        break;

    case 'gpu':
        $ejecucion->Ejecutar('uso_gpu');
        break;

    default:
        echo json_encode(["Accion no valida"]);
        break;
}
?>