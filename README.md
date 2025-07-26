# 🗳️ Projeto Api - Eleitores

Aplicação web 100% PHP para gerenciamento de eleitores, candidatos e votos. Utiliza PHP puro com integração a banco de dados, interface baseada em AdminLTE e pipeline automatizada via GitHub Actions + Docker + Terraform + Koyeb.


## 🚀 Funcionalidades

- Cadastro e gerenciamento de eleitores
- Associação de eleitores a candidatos
- Painel administrativo responsivo (AdminLTE)
- Login seguro com hash de senha
- API para integração com frontend ou terceiros
- Deploy automatizado via Docker + Terraform + Koyeb


## 📁 Estrutura do Projeto


├── assets/ # Frontend (CSS, JS, imagens)

├── config/ # Configurações de banco e ambiente

├── .github/workflows/ # GitHub Actions (CI/CD)

├── index.php # Entrada principal

├── login.php / logout.php # Autenticação

├── generate_hash.php # Utilitário de hash de senha

├── Dockerfile # Imagem Docker

├── docker-compose.yml # Stack local (Apache + MySQL)

├── composer.json # Dependências

├── phpunit.xml # Testes

└── .env # Variáveis de ambiente

## Documentação da API

Utilize os comandos abaixo para testar os endpoints da API autenticados com seu token:

1. Criar Eleitor
curl --location 'http://localhost8080/admin/api/customer/create.php' \
--header 'Authorization: Bearer [SEU_TOKEN_AQUI]' \
--header 'Content-Type: application/json' \
--data '{
  "name": "Eleitor Teste",
  "cpf": "08920194920",
  "candidate_id": 1001,
  "neighborhood": "Centro",
  "cep": "12345-678",
  "necessity": "Precisa de transporte"


1. Listar Candidatos
curl --location 'http://localhost8080/admin/api/candidates/list.php' \
--header 'Authorization: Bearer [SEU_TOKEN_AQUI]'

2. Listar Eleitores
curl --location 'http://localhost:8080/admin/api/customer/list.php' \
--header 'Authorization: Bearer [SEU_TOKEN_AQUI]'

## 🧪 Como rodar localmente

### Pré-requisitos

- Docker + Docker Compose
- PHP ≥ 8.1 (caso não use Docker)
- MySQL 8 ou superior

### Passos

# Clone o repositório

git clone https://github.com/seuusuario/eleitor-projeto.git
cd eleitor-projeto

# Suba o ambiente com Docker
docker-compose up -d

Imagem no cloudhub:
https://hub.docker.com/r/estertavares2025/eleitor-projeto-app

estertavares2025/eleitor-projeto-app:latest

# Acesse em http://localhost:8080

##  ⚙️ Configuração
Copie o arquivo .env.example para .env e configure:

env
Copiar
Editar
DB_HOST=db
DB_NAME=eleitor
DB_USER=admin
DB_PASSWORD=admin123

## 🧪 Testes
Rodar testes com PHPUnit:

Copiar
Editar
vendor/bin/phpunit

## 📦 Deploy (CI/CD)

A aplicação está preparada para deploy automatizado via GitHub Actions utilizando:

Docker Hub para build da imagem

Terraform para provisionamento

Koyeb como plataforma de hospedagem

🛠️ Tecnologias Utilizadas

PHP 8.1

MySQL 8

AdminLTE 3

Docker & Docker Compose

GitHub Actions

Terraform + Koyeb

## 📝 Licença

Este projeto é licenciado sob a licença MIT.
