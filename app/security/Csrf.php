<?php 

class Csrf{
    private $token;

    public function gerarToken(): string {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    public function verificarToken(?string $tokenForm): bool {
        if (empty($tokenForm) || empty($_SESSION['csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['csrf_token'], $tokenForm);
    }

    public function campoHidden(): string {
        $token = htmlspecialchars($this->gerarToken(), ENT_QUOTES, 'UTF-8');
        return '<input type="hidden" name="csrf_token" value="' . $token . '">';
    }

    public function renovar(): void {
            unset($_SESSION['token']);
            $this->gerarToken();
        }
    
}