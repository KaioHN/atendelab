<?php
//Controller de entidades usuarios

class UsuariosController{
    //conexão PDO reutilizada em todos os métodos
    private PDO $pdo;

    public function _construct(){
        //importando o arquivo que inicializa o objeto $pdo
        require _DIR_ . '/../../config/database.php';
        $this->pdo = $pdo;
    }

    public function listar(): void{
        //definindo saida em JSON para APIs/consumo por frontend
        header('Content-Type: application/json; charset=utf-8');

        //Consulta os usuarios com ordenação decrescente por ID.
        $sql = 'SELECT id, nome, email, perfil, status, criado_em
                FROM usuarios
                ORDER BY id DESC';

        $stmt = $this->pdo->query($sql);
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function buscarPorId() : void {
        header('Content-Type: application/json; charset=utf-8');

        // lê e valida o ID recebido por GET
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$id){
            http_response_code(400);
            echo json_encode(['erro' => 'ID inválido']);
            return
        }

        $sql 'SELECT id, nome, email, perfil, status, criado_em
                FROM usuarios
                WHERE id = :id';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!usuario) {
            http_response_code(404);
            echo json_encode(['erro'=> "Usuário não encontrado."]);
            return;
        }
        
        echo json_encode($usuario, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

    public function criar(): void{
        header('Content-Type: application/json; charset=utf-8');
        
        $nome = trim($_POST['nome']??'');
        $email = trim($_POST['email']??'');
        $senha = $_POST['senha']??'';
        $perfil = $_POST['perfil']??'atendente';
        $status = $_POST['status']??'ativo';

        if ($nome === '' || $email ==='' || $senha === ''){
            http_response_code(400);
            echo json_encode(['erro' => 'Nome, e-mail e senha são obrigatórios.']);
            return;
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            http_response_code(400);
            echo json_encode(['erro' => 'E-mail inválido.']);
            return;
        }
    }
}