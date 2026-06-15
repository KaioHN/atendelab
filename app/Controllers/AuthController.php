<?php

require_once __DIR__ . '/../../config/database.php';

require_once __DIR__ . '/../Middleware/auth.php';

class AuthController{
    private PDO $pdo;

    public function _construct(){
        global $pdo;

        $this->pdo = $pdo;
    }

    public function exibirLogin(): void{
        if (usuarioAutenticado()){
            header('Location: ?controller=auth&action=dashboard');
            exit;
        }

        $erro = $_SESSION['erro_login'] ?? null;
        $mensagem = $_SESSION['mensagem'] ?? null;

        unset($_SESSION['erro_login'], $_SESSION['mensagem']);

        require __DIR__ . '/../Views/auth/login.php';
    }

    public function entrar(): void{
        if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
            header('Location: ?controller-auth&action=login');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        if ($email === '' || $senha ===''){
            $_SESSION['erro_login'] = 'Informe o e-mail e a senha.';

            header('Location: ?controller=auth&action=login');
            exit;
        }
    }
}