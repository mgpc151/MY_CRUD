<?php
 require_once __DIR__ . "/../config/database.php";

 class Tarefas{
    private mysqli $conn;

    public function __construct(){
        $banco = new DataBase();

        $this->conn = $banco->conectar();
    }

    #listar 
    public function listar(int $user_id){
        $sql = "SELECT * FROM tarefas WHERE usuario_id = ? ORDER BY data_criacao DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    #criar
    public function criar(string $descricao, int $usuario_id){
        $descricao = $this->conn->real_escape_string($descricao);
        $user_id = intval($usuario_id);
        $sql = "INSERT INTO tarefas (descricao,usuario_id) VALUES (?,?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("si",$descricao,$usuario_id);
        $resultado =  $stmt->execute();
        $stmt->close();
        return $resultado;
        
        
    }

    #excluir 
    public function deletar(int $id,int $usuario_id){
        $id = intval($id);
        $usuario_id = intval($usuario_id);
        $sql = "DELETE FROM tarefas WHERE id = ? AND usuario_id = ? ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii",$id,$usuario_id);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }
    
    #atualizar
    public function atualizar(string $descricao, int $id,int $usuario_id){
        $descricao = $this->conn->real_escape_string($descricao);
        $id = intval($id);
        $usuario_id = intval($usuario_id);
        $sql = "UPDATE tarefas SET descricao = ? WHERE id = ? AND usuario_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sii",$descricao,$id,$usuario_id);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    }

 }