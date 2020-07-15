# Instalação

Execute para iniciar:  
```
docker-compose build
docker-compose up -d
```

Execute para criar as tabelas:
```
docker exec -it picpay-php-fpm ./bin/console doc:mig:mig
```

Execute para carregar fixtures:
```
docker exec -it picpay-php-fpm ./bin/console doc:fixtures:load
```

Para testar a API:
```
curl --location --request POST 'http://localhost:8001/transaction' \
--header 'Content-Type: application/json' \
--data-raw '{
    "value" : 50.00,
    "payer" : 1,
    "payee" : 2
}'
 ```