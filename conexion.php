<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

class Conexion extends PDO
{
    private $host;
    private $nombreBD;
    private $usuario;
    private $contraseña;

    public function __construct()
    {
        try
        {
            $config = json_decode(file_get_contents("config.json"), true);

            $this->host = $config['database']['host'];
            $this->nombreBD = $config['database']['dbname'];
            $this->usuario = $config['database']['user'];
            $this->contraseña = $config['database']['password'];

            parent::__construct(
                'mysql:host=' . $this->host . ';dbname=' . $this->nombreBD . ';charset=utf8',
                $this->usuario,
                $this->contraseña,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        }
        catch(PDOException $e)
        {
            echo 'Error: ' . $e->getMessage();
            exit;
        }
    }
}
?>