### Gerenciador de catálago de produtos :page_with_curl:

<img src="https://img.shields.io/static/v1?label=COVERAGE&message=100&color=green&style=for-the-badge"/> <img src="https://img.shields.io/static/v1?label=Licese&message=MIT&color=blue&style=for-the-badge"/> <img src="https://img.shields.io/static/v1?label=PHP&message=7.2.31&color=purple&style=for-the-badge&logo=PHP"/> <img src="https://img.shields.io/static/v1?label=LARAVEL&message=6.2&color=red&style=for-the-badge&logo=LARAVEL"/>

### Tópicos

:small_blue_diamond: [Descrição do projeto](#descrição-do-projeto)

:small_blue_diamond: [Features](#features)

:small_blue_diamond: [Pré-requisitos](#pré-requisitos)

:small_blue_diamond: [Como rodar a aplicação ](#como-rodar-a-aplicação-arrow_forward)

:small_blue_diamond: [Como rodar os testes ](#como-rodar-os-testes)


## Descrição do Projeto

Desenvolver uma plataforma capaz de gerenciar um catálago de produtos.

### Features
- Cadastro de produtos
- Atualização de produtos
- Exclusão de produtos
- Listagem do produtos cadastros

> Status do Projeto: Concluido :heavy_check_mark:

## Pré-requisitos

:warning: [Docker](https://www.docker.com/) :whale: 

:warning: [Docker compose](https://docs.docker.com/compose/) :octopus:

## Como rodar a aplicação :arrow_forward:

No terminal, clone o projeto:

```
git clone git@github.com:leotramontini/catalog-manager.git
```

Entre na pasta do docker que está dentro do projeto:

```
cd manager-products/docker
```

Vamos construir os container com os seguintes comandos:

```
docker-compose build && docker-compose up -d
```

Devemos verificar se as imagens estão de pé pelo comando:

```
docker ps
```

Aparacerá três containers: pgadmin, application e postgres.

Editar o seguinte arquivo:

```
sudo nano /etc/hosts
```

Adicionar:

```
127.0.0.1	manager-product.local
```

Temos que entrar no container `application` para instalar as dependências do projeto, execute o comando:

```
docker exec -ti application bash
```

Em seguida entrar com o usuário docker :whale: :

```
su docker
```

Entrar na pasta do projeto:

```
cd manager-products
```

Instalar as dependências do PHP :elephant: :

```
composer install
```

Instalar as dependências do JS e compila-las:

```
npm install && npm run dev
```

Criar o arquivo `.env` apartir do `.env.example` e alterar as seguintes informações:

```
DB_CONNECTION=pgsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=manager-product
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

Gerar a encryption key do laravel:

```
php artisan key:generate
```

Precisamos criar a chave para o JWT:

```
php artisan jwt:secret
```

Para configurar o banco de dados em um browser acesse `localhost:5050`, usaremos as seguintes credenciais:

| email  | senha  |
| ------------ | ------------ |
|  pgadmin4@pgadmin.org | postgres  |

Em `Serves` clique com o botão direito do mouse e clique na opção `Create` :arrow_right: `Servers`

Abrirá uma tela e devemos colocar as seguintes informações:

| Campo  | Valor  | Aba  |
| ------------ | ------------ | ------------ |
|  Name | manager-product  | General  |
| Host name/connection  |  postgres | Connection  |
| Username |  postgres | Connection  |
| Password  |  postgres | Connection  |

Clicar no botão :floppy_disk: `Save`

Em seguida clicar com o botão direito em cima de `Databases` e selecionar a opção `Create` :arrow_right: `Database...`

|  Campo | Valor  |
| ------------ | ------------ |
| Database | manager-product  |

Clicar no botão :floppy_disk: `save` e o banco de dados está configurado

Rodar as migrations e seeds criadas:

```
php artisan migration --seed
```

Executar o comando:

```
php artisan storage:link
```

Agora podemos acessar no browser:

`http://manager-product.local/`

Credenciais para acesso:

|  Email | Senha  |
| ------------ | ------------ |
|   admin@email.com | admin  |

E utilizar a aplicação sem moderação

## Como rodar os testes

Coloque um passo a passo para executar os testes

```
$ ./vendor/bin/phpunit
```

## Linguagens, dependencias e libs utilizadas :books:

- [PHP](https://www.php.net/)
- [Laravel](https://laravel.com/docs/6.x)
- [Repository](https://github.com/andersao/l5-repository)
- [Dingo api](https://github.com/dingo/api)
- [JWT](https://github.com/tymondesigns/jwt-auth)
- [Vue.js](https://vuejs.org/)
- [Vue router](https://router.vuejs.org/)
- [Vuex](https://vuex.vuejs.org/)
- [Vue reourse](https://github.com/pagekit/vue-resource)

## Licença

The [MIT License]() (MIT)

Copyright :copyright: 2020 - Gerenciado de catálago



