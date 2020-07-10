# O que é?
Esse sistema consiste numa api para transferência de dados entre um ou mais usuários.

# Desenvolvido com

    Laravel 7.12.0

# Requisitos

    PHP >= 7.4
    BCMath PHP Extension
    Ctype PHP Extension
    Fileinfo PHP extension
    JSON PHP Extension
    Mbstring PHP Extension
    OpenSSL PHP Extension
    PDO PHP Extension
    Tokenizer PHP Extension
    XML PHP Extension
    
## Ambiente de desenvolvimento

Este projeto foi feito utilizando Docker. O projeto do ambiente pode ser encontrado abaixo:

    https://github.com/vitorapaiva/docker-laravel

### Configurações do ambiente de desenvolvimento

* Copie localmente o projeto docker-laravel para sua maquina: 
          
      git clone https://github.com/vitorapaiva/docker-laravel.git

* Dentro da pasta criada, crie uma cópia do .env.example chamada .env
* Preencha as variáveis de ambiente

        MYSQL_DATA=/caminho/para/base/mysql
        MYSQL_ROOT_PASSWORD=senha-do-root
        MYSQL_DATABASE=nome-do-banco
        MYSQL_USER=login=do-usuario
        MYSQL_PASSWORD=senha-do-usuario
        APP_PATH=/caminho/para/a/aplicacao/na/sua/maquina

## Instalação do projeto
* crie uma copia do .env.example chamada .env e configure as seguintes variaveis:
        
        DB_CONNECTION=seu-db
        DB_HOST=host
        DB_PORT=porta
        DB_DATABASE=nome-do-banco
        DB_USERNAME=seu-login
        DB_PASSWORD=sua-senha
    
* use estas configurações para caso esteja utilizando o docker-laravel
    
        DB_HOST=docker-laravel-mysql
        DB_DATABASE=nome-do-banco
        DB_USERNAME=seu-login
        DB_PASSWORD=sua-senha

* Execute esses comandos
  
        composer install
        php artisan key:generate
        php artisan migrate

## Testes

Para testar a aplicação, voce pode usar o teste de integração, que valida todo o fluxo da transferência

    phpunit tests/Integration/Transfer/TestMoneyTransfer.php

Que deve trazer o resultado:

    PHPUnit 8.5.8 by Sebastian Bergmann and contributors.
    
    ..                                                                  2 / 2 (100%)
    
    Time: 3.7 seconds, Memory: 22.00 MB
    
    OK (2 tests, 14 assertions)

