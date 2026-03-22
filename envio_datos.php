<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'insertar_ejecucion.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['insertar']) && $_GET['insertar'] === '1') 
{
    $inyeccion = new Inyectar_Ejecutar();
    $inyeccion->Inyectar();
} 
else 
{
    $ejecucion = shell_exec("python ./prueba.py");
    $parametros = json_decode($ejecucion, true);

    echo json_encode([
        'uso_cpu'     => $parametros['uso_cpu'],
        'uso_memoria' => $parametros['uso_memoria'],
        'uso_disco'   => $parametros['uso_disco'],
        'uso_gpu'     => $parametros['uso_gpu'],
        'fecha'       => date("Y-m-d"),
        'hora'        => date("H:i:s")
    ]);
}
?>