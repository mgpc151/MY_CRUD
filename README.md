# MY_CRUD

Aplicação web simples de gerenciamento de usuários e tarefas, desenvolvida em PHP com MySQL. O projeto usa uma organização MVC básica, sessões para autenticação e consultas preparadas para acessar o banco de dados.

## Funcionalidades

- Cadastro de usuário com validação básica dos campos e senha protegida com `password_hash`.
- Login e logout usando sessão.
- Criação, edição, listagem e exclusão de tarefas.
- Tarefas associadas ao usuário autenticado.
- Edição e exclusão da própria conta.
- Tokens CSRF nos formulários que alteram dados.

## Tecnologias e requisitos

- PHP 7.4 ou superior.
- Extensão PHP `mysqli` habilitada.
- MySQL ou MariaDB.
- Navegador web moderno.

## Configuração do banco de dados

Por padrão, a aplicação conecta ao banco `login` em `127.0.0.1`, usando o usuário `root` sem senha. Esses valores estão em `app/config/database.php`; altere-os para corresponder à sua instalação local.

Crie o banco e as tabelas esperadas pelos modelos executando este SQL no MySQL ou MariaDB:

```sql
CREATE DATABASE login
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE login;

CREATE TABLE usuarios (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  nome VARCHAR(120) NOT NULL,
  email VARCHAR(255) NOT NULL,
  senha VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_usuarios_email (email)
) ENGINE=InnoDB;

CREATE TABLE tarefas (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  descricao TEXT NOT NULL,
  usuario_id INT UNSIGNED NOT NULL,
  data_criacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_tarefas_usuario_data (usuario_id, data_criacao),
  CONSTRAINT fk_tarefas_usuario
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id)
    ON DELETE CASCADE
) ENGINE=InnoDB;
```

A tabela `tarefas` usa `data_criacao` para ordenar as tarefas no painel. A chave estrangeira com `ON DELETE CASCADE` remove as tarefas quando a conta correspondente é excluída.

## Como executar localmente

1. Configure as credenciais do MySQL em `app/config/database.php`.
2. Crie o banco e as tabelas com o SQL acima.
3. No terminal, entre na pasta raiz do projeto, onde está `index.php`.
4. Inicie o servidor embutido do PHP:

   ```bash
   php -S localhost:8000
   ```

5. Acesse [http://localhost:8000](http://localhost:8000) no navegador e crie uma conta.

O servidor embutido do PHP serve para desenvolvimento local. Para publicar a aplicação, configure um servidor web com PHP e MySQL e use HTTPS.

## Estrutura do projeto

```text
MY_CRUD/
├── index.php                 # Ponto de entrada e roteador
└── app/
    ├── config/
    │   └── database.php      # Conexão com MySQL
    ├── controller/
    │   ├── UserController.php
    │   └── TarefaController.php
    ├── model/
    │   ├── Usuario.php
    │   └── Tarefas.php
    ├── security/
    │   └── Csrf.php
    └── view/
        ├── style/
        ├── login.php
        ├── cadastrar.php
        ├── painel.php
        ├── listar.php
        ├── editarUsuario.php
        ├── editarTarefa.php
        └── deletarModal.php
```

## Rotas principais

As rotas são selecionadas pelo parâmetro `action` de `index.php`.

| Ação | Descrição |
| --- | --- |
| `index` | Exibe o login |
| `cadastrar` | Exibe o formulário de cadastro |
| `autenticar` | Processa o login |
| `painel` | Exibe o painel e as tarefas do usuário |
| `criar` | Cria uma conta |
| `atualizar` | Atualiza os dados da conta |
| `excluirConta` | Exclui a conta |
| `criarTarefa` | Cria uma tarefa |
| `atualizarTarefa` | Atualiza uma tarefa |
| `deletarTarefa` | Exclui uma tarefa |
| `logout` | Encerra a sessão |

As ações que alteram dados devem ser enviadas por formulário `POST` com o token CSRF incluído.
