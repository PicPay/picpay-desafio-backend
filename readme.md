# Desafio PP

- Crie o arquivo .env
```
cp .env.example .env
```

- Inicie os containers
```
docker-compose up -d
```

- Execute as dependências
```
docker-compose exec app composer install
```

- Gere a chave da aplicação
```
docker-compose exec app php artisan key:generate
```

- Crie as tabelas
```
docker-compose exec app php artisan migrate
```

- Insira os registros já configurados
```
docker-compose exec app php artisan db:seed
```

- Acesse o link
```
http://127.0.0.1:81
```

## Fluxo de transferência

![image](fluxo_de_transferencia.png)