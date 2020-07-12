<p align="center">
    <img src="https://miro.medium.com/max/9644/1*0p48XIDSTTvZbi8gCpCYog.png" height="100">
</p>

---

## Requisitos

* Composer
* Docker
* Git

## Como iniciar o projeto

Buildar as imagens do docker
```
docker-compose build
```
Pronto, agora voce pode subir as imagens
```
docker-compose up -d
```
Agora rodar as migrações e seeds
```
docker-compose exec api.desafio.dev php artisan migrate:fresh --seed
```
(opcional) Para fazer a gestão da fila pelo banco de dados
```
alterar o .env queue_connection para database
docker-compose exec api.desafio.dev php artisan queue:work
```
## Como testar ?

### Postman
Através da url definida no docker http://localhost:8000/api/v1/transaction

Payload:
{
    "payer": "1",
    "payee": "2",
    "value": "12"
}

### PHPUnit
docker-compose exec api.desafio.dev vendor/bin/phpunit -c ./phpunit.xml