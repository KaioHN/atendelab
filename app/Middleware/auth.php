<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function usuarioAutenticacao(): void{
        if (!usuarioAutenticacao()){
            $_SESSION['mensagem'] = 
                    'Faca login para acessar a area restrita.';

                header('Location: ?controller=auth&action=login');
                exit;
        }
}

function usuarioAtual(): ?array{
    return $_SESSION['usuario'] ?? null;
}