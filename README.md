# O que é?
Esse sistema consiste numa api para transferência de dados entre um ou mais usuários.

# Desenvolvido com

* Laravel 7.12.0

# Requisitos

* PHP >= 7.4
* BCMath PHP Extension
* Ctype PHP Extension
* Fileinfo PHP extension
* JSON PHP Extension
* Mbstring PHP Extension
* OpenSSL PHP Extension
* PDO PHP Extension
* Tokenizer PHP Extension
* XML PHP Extension
    
## Ambiente de desenvolvimento

https://github.com/vitorapaiva/docker-laravel

### Configurações do ambiente de desenvolvimento

* Copie localmente o projeto docker-laravel para sua maquina: https://github.com/vitorapaiva/docker-laravel.git
* Dentro da pasta criada, crie uma cópia do .env.example chamada .env
* Preencha as variáveis de ambiente

    * MYSQL_DATA=/caminho/para/base/mysql
    * MYSQL_ROOT_PASSWORD=senha-do-root
    * MYSQL_DATABASE=nome-do-banco
    * MYSQL_USER=login=do-usuario
    * MYSQL_PASSWORD=senha-do-usuario
    * APP_PATH=/caminho/para/a/aplicacao/na/sua/maquina

## Instalação do projeto
* crie uma copia do .env.example chamada .env e configure as seguintes variaveis:
    * DB_CONNECTION=seu-db
    * DB_HOST=host
    * DB_PORT=porta
    * DB_DATABASE=nome-do-banco
    * DB_USERNAME=seu-login
    * DB_PASSWORD=sua-senha
    
* use estas configurações para caso esteja utilizando o docker-laravel
    * DB_HOST=docker-laravel-mysql
    * DB_DATABASE=nome-do-banco
    * DB_USERNAME=seu-login
    * DB_PASSWORD=sua-senha
    
* composer install
* php artisan key:generate
* chown -R www-data:www-data storage (para consertar erro ocasional de permissao na pasta storage. Caso nao ocorra no seu ambiente, nao precisa utilizar)

