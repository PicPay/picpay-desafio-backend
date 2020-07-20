## Teste PICPAY

### Tecnologias utilizadas
* PHP 7.2
* Laravel 7
* Docker
* Redis
* MariaDb

### Desenvolvido com:
* Linux Mint
* Visual Studio
* PostMan

### Fluxograma e MER disponíveis na pasta DOCS

### Iniciar docker
docker-compose up -d --build

### Generate key do laravel
docker-compose exec app artisan key:generate

### Criar database
docker-compose exec db  mysql -u root -e "CREATE DATABASE picpay;"

### Criar migrate das tabelas
docker-compose exec app artisan migrate

### Popula banco de dados com usuários e valores no histórico da conta;
docker-compose exec app artisan db:seed

### Teste Unitario
docker-compose exec app php artisan test

#Processa a fila das transações
docker-compose exec app php artisan queue:work --queue=transactions

#Processa a fila das notificações
docker-compose exec app php artisan queue:work --queue=notification