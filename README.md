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

### Esboços de fluxograma e MER 
Disponíveis na pasta DOCS na raiz da aplicação

### Iniciar docker
```
docker-compose up -d --build
```
### Arquivo de variaveis do ambiente
```
docker-compose exec app cp .env.example .env
```

### Generate key do laravel
```
docker-compose exec app php artisan key:generate
```

### Criar database
```
docker-compose exec db  mysql -u root -e "CREATE DATABASE picpay;"
```

### Criar migrate das tabelas
```
docker-compose exec app php artisan migrate
```

### Popula banco de dados com usuários e valores no histórico da conta;
```
docker-compose exec app php artisan db:seed
```

### Teste Unitario
```
docker-compose exec app php artisan test
```

### Processa a fila das transações
```
docker-compose exec app php artisan queue:work --queue=transactions
```

### Processa a fila das notificações
```
docker-compose exec app php artisan queue:work --queue=notification
```

### Endpoint da api
```
POST
/api/transaction
{
    "value" : 1,
    "payer" : 3,
    "payee" : 5
}

```

```
POST
/api/user
{
    "name" : "Teste",
    "email" : "teste@example.org",
    "document" : "12345678900",
    "type" : "PERSON"
}
```

### References
* https://laravel.com/docs/7.x/
* https://redis.io/
* https://github.com/phpredis/phpredis