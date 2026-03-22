<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

class Conexion extends PDO
{
    private $host='127.0.0.1:3308';
    private $nombreBD='proyecto';
    private $usuario='root';
    private $contraseña='root';

    public function __construct()
    {
        try
        {
            parent::__construct('mysql:host='  .  $this->host . ';dbname=' . $this->nombreBD . ';charset=utf8',
            $this->usuario,  $this->contraseña, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        catch(PDOException $e)
        {
            echo 'Error: '  .  $e->getMessage();
            exit;
        }
    }
}
?>