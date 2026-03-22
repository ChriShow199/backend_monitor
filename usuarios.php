<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

include 'conexion.php'; // Clase Conexion que retorna instancia PDO

class Usuarios
{
public function Registro()
{
    $data = json_decode(file_get_contents("php://input"), true);
    $correo = $data['correo'] ?? '';
    $contrasena = $data['contrasena'] ?? '';
    $rol = $data['rol'] ?? '';

    if ($correo && $contrasena && $rol)
    {
        $hash = password_hash($contrasena, PASSWORD_BCRYPT);
        try 
        {
            $pdo = new Conexion();
            $sql = $pdo->prepare("INSERT INTO usuarios (correo, contrasena, rol) VALUES (:correo, :contrasena, :rol)");
            $sql->execute(['correo' => $correo, 'contrasena' => $hash, 'rol' => $rol]);

            echo json_encode(['status' => 'ok', 'correo' => $correo, 'rol' => $rol]); // 👈 Retornamos los datos
        } 
        catch (PDOException $e) 
        {
            echo json_encode(['status' => 'error', 'message' => 'Correo ya registrado']);
        }
    }
    else 
    {
        echo json_encode(['status' => 'error', 'message' => 'Faltan campos']);
    }
}


    public function Login()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $correo = $data['correo'] ?? '';
        $contrasena = $data['contrasena'] ?? '';

        if ($correo && $contrasena) 
        {
            $pdo = new Conexion();
            $sql = $pdo->prepare("SELECT contrasena, rol FROM usuarios WHERE correo = :correo");
            $sql->execute(['correo' => $correo]);
            $user = $sql->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($contrasena, $user['contrasena'])) 
            {
                echo json_encode(['status' => 'ok', 'correo' => $correo, 'rol' => $user['rol']]);
            } 

            else 
            {
                echo json_encode(['status' => 'error', 'message' => 'Credenciales incorrectas']);
            }
        } 

        else 
        {
            echo json_encode(['status' => 'error', 'message' => 'Faltan campos']);
        }
    }


    public function Roles()
    {
        try 
        {
            $pdo = new Conexion();
            $sql = $pdo->query("SELECT IDRol, nombreRol FROM roles");
            $roles = $sql->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($roles);
        } 

        catch (PDOException $e) 
        {
            echo json_encode(['Error al obtener roles']);
        }
    }
}

// Ejecutar acción
$usuarios = new Usuarios();
$accion = $_GET['accion'] ?? '';

switch ($accion) 
{
    case 'registro':
        $usuarios->Registro();
        break;

    case 'login':
        $usuarios->Login();
        break;
    
    case 'roles':
        $usuarios->Roles();
        break;

    default:
        echo json_encode(['Accion no valida']);
        break;
}
?>
