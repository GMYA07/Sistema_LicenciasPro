<?php
require_once __DIR__ . '/../../core/Database.php';
class AuthController {
    public function index() {
        include '../app/views/auth/login.php';
    }

    public function procesarLogin(){
        //Recibimos los datos del formulario
        $usuario = $_POST['usuario'];
        $passwordPlano = $_POST['pass'];

        //Conecto la base de datos
        $db = (new Database())->getConnection();

        //Buscamos el usuario
        $stmt = $db->prepare("SELECT * FROM usuarios WHERE usuario = :user LIMIT 1");
        $stmt->execute(['user' => $usuario]);

        $usuarioDB = $stmt->fetch(); // Recibiremos un objeto user desde la base de datos

        //verifica si el usuario existe y si la contra es correcta
        if($usuarioDB && password_verify($passwordPlano, $usuarioDB->pass)){
            //Comprobar si la contraseña esta activa
            if($usuarioDB->estadoUsuario == 1){
                //login exitoso
                session_start();
                $_SESSION['usuario_id'] = $usuarioDB->idUsuario;
                $_SESSION['usuario_nombre'] = $usuarioDB->usuario;

                //redirigimos al sistema
                header('Location:'.BASE_URL.'/home');
                exit;
            }else{
                echo "Tu cuenta esta desactivada";
            }
        }else{
            //No se pudo iniciar sesion
            header('Location: ' . BASE_URL . '/');
            exit;
        }


    }

    public function cerrarSesion(){
        //Reanudar la sesion para poder manipular
        session_start();
        //vaciar las variables de sesion
        session_unset();
        //destruir la sesion
        session_destroy();

        header('Location:'.BASE_URL.'/');
        exit;

    }
}
