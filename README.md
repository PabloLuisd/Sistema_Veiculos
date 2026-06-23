# Sistema de Gerenciamento de Veículos

Sistema web desenvolvido em PHP e MySQL para gerenciamento de veículos e marcas, com autenticação de usuários e controle de acesso.

## Funcionalidades

### Usuários
- Cadastro de usuários
- Login
- Logout
- Controle de sessão
- Restrição de acesso às páginas internas

### Veículos
- Cadastro de veículos
- Listagem de veículos cadastrados
- Edição de veículos
- Exclusão de veículos

### Marcas
- Cadastro de marcas
- Listagem de marcas
- Exclusão de marcas
- Validação para impedir exclusão de marcas vinculadas a veículos

---

## Tecnologias Utilizadas

- PHP 8
- MySQL 8
- HTML5
- CSS3
- Bootstrap 5
- Docker
- phpMyAdmin

---

## Estrutura do Projeto

```text
www/
│
├── back/
│   ├── processa_login.php
│   ├── processa_cadastro.php
│   ├── processa_veiculo.php
│   ├── processa_marca.php
│   ├── editar_veiculo.php
│   ├── excluir_veiculo.php
│   ├── excluir_marca.php
│   └── logout.php
│
├── config/
│   └── conecta.php
│
├── index.php
├── cadastro.php
├── dashboard.php
├── veiculo_form.php
├── marca_form.php
│
└── docker-compose.yml
```

---

## Banco de Dados

O sistema utiliza três tabelas principais:

### usuarios

| Campo | Tipo |
|---------|---------|
| id | INT |
| nome | VARCHAR(100) |
| email | VARCHAR(150) |
| senha | VARCHAR(255) |

### marcas

| Campo | Tipo |
|---------|---------|
| id | INT |
| marca | VARCHAR(100) |

### veiculos

| Campo | Tipo |
|---------|---------|
| id | INT |
| modelo | VARCHAR(100) |
| marca_id | INT |
| potencia | INT |
| ano_fabricacao | INT |
| tipo | ENUM |

---

## Como Executar

### Subir os containers

```bash
docker compose up -d
```

### Acessar o sistema

```text
http://localhost:8080
```

### Acessar o phpMyAdmin

```text
http://localhost:8081
```

Usuário:

```text
root
```

Senha:

```text
1234
```

---

## Segurança

- Controle de sessão
- Proteção de páginas privadas
- Senhas criptografadas com `password_hash()`
- Verificação de senha com `password_verify()`
- Validação de formulários
- Prepared Statements em consultas críticas

---

## Regras de Negócio

- Não é permitido cadastrar usuários com e-mail duplicado.
- Todos os veículos devem possuir uma marca cadastrada.
- Não é permitido excluir uma marca vinculada a veículos.
- Apenas usuários autenticados podem acessar o sistema.

---

## Autor

Pablo Da Silva

Projeto desenvolvido para a disciplina de Desenvolvimento Web.