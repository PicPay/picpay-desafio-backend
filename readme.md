# Laravel Carteira

Projeto em laravel para transferencia de saldos

## Requisitos

-   [Git](https://git-scm.com/)
-   [Docker](https://www.docker.com/get-started)

## Importante

Antes de subir os containers do docker é necessário liberar as portar:
- 80
- 8081
- 3306

## Instalação

1. Clone ou baixe o repositorio e execute os comandos:

    ```bash
    cd picpay-desafio-backend/laradock
    cp env-example .env

    # Linux - Criar os containers (OBS: Demora um pouco na primeira vez)
    sudo docker-compose up -d nginx mysql phpmyadmin workspace
    sudo docker-compose exec --user=laradock workspace bash

    # Windows - Criar os containers, utilizar CMD ou SHELL (OBS: Demora um pouco na primeira vez)
    docker-compose up -d nginx mysql phpmyadmin workspace
    docker-compose exec --user=laradock workspace bash

    # Instalação das dependencias do Laravel
    composer install
    cp .env.example .env
    php artisan key:generate
    php artisan migrate --seed
    ```
    
2. Agora você deve ser capaz de visualizar a sua aplicação funcionando.

    [http://localhost](http://localhost) 

3. Acessar o Banco de dados com o phpmyadmin

    >[http://localhost:8081](http://localhost:8081)  
    >Servidor: mysql  
    >Usuario: laravel  
    >Senha: laravel  
