<?php 
    //Carregar Controller responsavel pelos endpoits de user
    require_once __DIR__ . '/app/Controllers/UsuariosControllers.php'

    //Definir Controller e action por query string.
    $controller = $GET['controller'] ?? 'home';
    $action = $GET['action'] ?? 'index';

    //Roteador é simples; Reconhece o Controller como "usuarios"
    if ($controller == 'usuarios'){
        $usuariosController = new UsuariosControllers();

            switch ($action){
                case ' listar':
                    $usuariosController->listar();
                    break;

                case 'buscar':
                    $usuariosController->buscarPorId();
                    break;

                case 'criar':
                    $usuariosController->criar();
                    break;

                case 'atualizar':
                    $usuariosController->atualizar();
                    break;

                case 'excluir':
                    $usuariosController->excluir();
                    break;

                    default:
                        echo 'Ação de usuários não encontrada.';
                        break;
            }
    } else {
        echo '<h1>AtendeLab</h1>';
        echo '<p>Projeto em execução. Use ?controller=usuarios&action=listar para testar.</p>'
    }