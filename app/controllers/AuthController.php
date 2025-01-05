<?php
$_authController = new AuthController;
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"]) && isset($_POST["password"])) {

    $_authController->login($_POST["email"], $_POST["password"]);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["type"] == "logout"){
    $_authController->logout();
}

class AuthController {

    // Método login
    public function login($email, $password) {
        // Incluir el archivo de conexión a la base de datos
        require_once '../../persistance/DAO/UserDAO.php';
        require_once '../models/User.php';

        $userDAO = new UserDAO();
        
        // Buscar usuario en la base de datos
        $user = $userDAO->findByEmail($email);
        
        if ($user == null){
            header('Location: ../views/public/index.php?error=UsuarioIncorrecto');
            exit();
        }

        if ($user->verifyPassword($password)) {
            // Iniciar sesión y guardar datos
            session_start();
            $_SESSION['email'] = $user->getEmail();
            $_SESSION['type'] = $user->getType();
            header("Location: ../../index.php");
            exit();
            return true;
        }else{
            header('Location: ../views/public/index.php?error=ContraseñaIncorrecta');
            exit();
        }
        return false;
    }

    // Método logout
    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: ../views/public/index.php");
        exit();
    }

    // Método para obtener el rol del usuario logueado
    public function getRole() {
        session_start();
        return isset($_SESSION['type']) ? $_SESSION['type'] : null;
    }
    
    public static function validateUser() {

        // Verificar si el usuario está logueado
        if (!isset($_SESSION['email']) || !isset($_SESSION['type'])) {
            return false; // Usuario no logueado
        }

        // Verificar si el rol del usuario es gestor
        $userRole = $_SESSION['email'];
        if ($userRole === 'gestor') {
            return "gestor"; // Usuario autorizado
        }else if ($userRole === 'admin') {
            return "admin"; // Usuario autorizado
        }

        return false; // Usuario no autorizado
    }
}
