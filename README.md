# Match Generator App

Este repositório contém uma aplicação Laravel que oferece APIs GraphQL para criar e gerenciar partidas de um campeonato esportivo. A aplicação inclui funcionalidades para o cadastro de jogadores, times e campeonatos, bem como a capacidade de gerar jogos para esses campeonatos.

## Requisitos

Antes de prosseguir, certifique-se de que você tenha o seguinte software instalado:

- [Laravel](https://laravel.com/docs/installation)
- [PostgreSQL](https://www.postgresql.org/download/)
- [Composer](https://getcomposer.org/)

## Instalação

Siga estas etapas para configurar e executar a aplicação em seu ambiente local:

1. Clone este repositório:

```bash
git clone https://github.com/karGuimaraes/campeonato.git
cd campeonato
```

2. Instale as dependências do Composer:

```bash
composer install
```

3. Copie o arquivo de exemplo de configuração `.env.example` para `.env`:

```bash
cp .env.example .env
```

4. Configure seu banco de dados PostgreSQL no arquivo `.env`. Certifique-se de definir as variáveis de ambiente como `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME` e `DB_PASSWORD`.

5. Execute as migrações do banco de dados para criar as tabelas necessárias:

```bash
php artisan migrate
```

6. Inicie o servidor de desenvolvimento:

```bash
php artisan serve
```

Agora, a aplicação está em execução e acessível em `http://localhost:8000/graphiql`. Você pode acessar a interface e documentação para testar e usar as APIs.

## Uso

A aplicação oferece as seguintes funcionalidades:

- Cadastro de jogadores.
- Cadastro de times.
- Criação de campeonatos.
- Geração de partidas para um campeonato.

## Testes Unitários

Este projeto inclui testes unitários para garantir a estabilidade do código. Para executar os testes, use o seguinte comando:

```bash
php artisan test
```
