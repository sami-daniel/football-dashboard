# Projeto Football-Dashboard

Este é um projeto desenvolvido com o framework Laravel (PHP), um dos frameworks mais populares para construção de aplicações web.

## Requisitos

Antes de rodar o projeto, verifique se você tem os seguintes requisitos:

- [PHP](https://www.php.net) (versão 8.0 ou superior)
- [Composer](https://getcomposer.org) para gerenciar as dependências

## Instalação

### 1. Clonando o repositório

Clone o repositório do projeto para a sua máquina local (Os processos a seguir podem ser realizados no 
powershell, bash, zhs e qualquer outro tipo de Shell):

```bash
git clone https://github.com/sami-daniel/football-dashboard.git
cd football-dashboard
```

### 2. Instalando dependências

```bash
composer install
```

### 3. Configurando o ambiente
```bash
cp .env.example .env
```

### 4. Gerando chave do sistema
```bash
php artisan key:generate
```

## Configurar chave da API

Entre no site do [Football Data Org](https://www.football-data.org/client/register).
Crie uma conta usando o email pessoal. 
Será enviado o token da API para o email cadastro.
Copie o token enviado no email.

No terminal, digite: 
```
echo API_KEY=cole-o-token-da-api-no-lugar-desse-texto >> .env
```
### 4. Rodar o projeto

```bash
php artisan serve
```
