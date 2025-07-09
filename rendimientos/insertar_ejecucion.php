<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

class Inyectar_Ejecutar
{
    public function Ejecutar($componente)
    {
        $ejecucion = shell_exec("python ./prueba.py");
        $parametros = json_decode($ejecucion, true);

        if (isset($parametros[$componente])) 
        {
            echo json_encode([$componente => $parametros[$componente]]);
        } 
        else 
        {
            echo json_encode(["Componente no encontrado"]);
        }
    }


    public function Inyectar()
    {
        include 'conexion.php';
        $pdo = new Conexion();

        date_default_timezone_set('America/Mexico_City');

        $ejecucion = shell_exec("python ./prueba.py");
        $parametros = json_decode($ejecucion, true);
        
        if($_SERVER['REQUEST_METHOD'] == 'GET' )
        {
            $sql = $pdo ->prepare("INSERT INTO rendimiento (uso_cpu, uso_memoria, uso_disco, uso_gpu, fecha_hora) 
                                    VALUES (:cpu, :memoria, :disco, :gpu, :fecha_hora)");
            $sql->execute([
                ':cpu'     => $parametros['uso_cpu'],
                ':memoria' => $parametros['uso_memoria'],
                ':disco'   => $parametros['uso_disco'],
                ':gpu'     => $parametros['uso_gpu'],
                ':fecha_hora'   => date("Y-m-d h:i:s")
            ]);
            echo json_encode([
            'uso_cpu' => $parametros['uso_cpu'],
            'uso_memoria' => $parametros['uso_memoria'],
            'uso_disco' => $parametros['uso_disco'],
            'uso_gpu' => $parametros['uso_gpu'],
            'fecha_hora' => date("Y-m-d h:i:s")
        ]);
        }
    }
}
?>