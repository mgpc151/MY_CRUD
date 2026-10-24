<?php 

require_once __DIR__ . '/../config/database.php'; 

Class Usuario{
    private mysqli $conn; 

    public function __construct(){
        $db = new Database(); 
        $this->conn = $db->conectar(); 
    }

    public function buscarPorEmail($email){
        $sql = "SELECT * FROM usuarios WHERE email = ?";
         $stmt = $this->conn->prepare($sql); 
         $stmt->bind_param("s", $email); 
         $stmt->execute();

         $resultado = $stmt->get_result();
         return $resultado->fetch_assoc();
    }

    # útil para o painel mostrar dados atuais
       public function buscarPorId(int $id) {
           $sql = "SELECT id, nome, email FROM usuarios WHERE id = ? LIMIT 1";
           $stmt = $this->conn->prepare($sql);
           $stmt->bind_param("i", $id);
           $stmt->execute();
           $resultado = $stmt->get_result()->fetch_assoc();
           $stmt->close();
           return $resultado;
       }
   
       # verifica e-mail duplicado
       public function emailExiste(string $email, int $ignorarId = 0): bool {
           $sql = "SELECT id FROM usuarios WHERE email = ? AND id <> ? LIMIT 1";
           $stmt = $this->conn->prepare($sql);
           $stmt->bind_param("si", $email, $ignorarId);
           $stmt->execute();
           $stmt->store_result();
           $existe = $stmt->num_rows > 0;
           $stmt->close();
           return $existe;
       }
   
       # criar
       public function criar(string $nome, string $email, string $senhaHash): bool {
           $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
           $stmt = $this->conn->prepare($sql);
           $stmt->bind_param("sss", $nome, $email, $senhaHash);
           $resultado = $stmt->execute();
           $stmt->close();
           return $resultado;
       }
   
       # atualizar (se $senhaHash for null, mantém a senha atual)
       public function atualizar(int $id, string $nome, string $email, ?string $senhaHash = null): bool {
           if ($senhaHash !== null) {
               $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
               $stmt = $this->conn->prepare($sql);
               $stmt->bind_param("sssi", $nome, $email, $senhaHash, $id);
           } else {
               $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
               $stmt = $this->conn->prepare($sql);
               $stmt->bind_param("ssi", $nome, $email, $id);
           }
           $resultado = $stmt->execute();
           $stmt->close();
           return $resultado;
       }
   
       # deletar
       public function deletar(int $id): bool {
           $sql = "DELETE FROM usuarios WHERE id = ?";
           $stmt = $this->conn->prepare($sql);
           $stmt->bind_param("i", $id);
           $resultado = $stmt->execute();
           $stmt->close();
           return $resultado;
       }

}




?>