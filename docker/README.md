# Versões
docker 2.3.0.3

debian:buster-slim

php 7.4.7

apache 2.4

laravel 6.18.8

mysql 8.0.20

RabbitMQ 3.8.5

# Comandos
docker-compose up -d

# Laravel
cd core

cp .env.example .env

php artisan key:generate

# Acessar App (vhost)
http://core.local

http://wallet.local

# Configuração de Vhost Local
127.0.0.1	core.local

[IP_DO_CONTAINER] wallet.local
Ou
acessar no navegador = http://localhost:81

[IP_DO_CONTAINER] transaction.local
Ou
acessar no navegador = http://localhost:82

# Informações de um container (Descobrir IP)
docker inspect [NOME_DO_CONTAINER]

docker inspect web_wallet

# Ativar Plugin RabbitMQ Management
acessar container: winpty docker exec -it rabbitmq bash

rodar comando: rabbitmq-plugins enable rabbitmq_management

obs: winpty é usado somente no windows.

# Acessar RabbitMQ Management
http://localhost:15672

usuário = guest

senha = guest

# URL Friendly
a2enmod rewrite
service apache2 restart
docker start web_core
docker start web_wallet
