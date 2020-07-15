# Transfer API
This project is an API of Money Transfer, based on [this](https://github.com/PicPay/picpay-desafio-backend/blob/master/readme.md) instructions

## Dependencies
- [Docker](https://www.docker.com/) (along with docker-compose)

## Setup
```shell script
git clone https://github.com/eriossp/picpay-desafio-backend
```
```shell script
cd picpay-desafio-backend
```
```shell script
sudo docker-compose up -d --build
```

### One container will be initialized:
- picpay-desafio-backend_esdras (REST API connected to the host port 8001)

>When the container is built, some sample data is imported into the database.

## Testing
```shell script
docker exec -it picpay-desafio-backend_esdras ./vendor/bin/phpunit
```

#### Database
![Relationship Entity Diagram](/DER.jpg)

## REST API
>[This file](/postman_collection.json) contains a [Postman](https://www.getpostman.com/) collection with some request examples.
### Request

POST /transaction

```json
{
    "value" : 100.00,
    "payer" : 4,
    "payee" : 15
}
```
### Response

```json
{
    "id": int,
    "payer_id": int,
    "payee_id": int,
    "amount": int,
    "status": "invalid" | "fails" | "succeeded",
    "updated_at": Date,
    "created_at": Date,
}
```
#### Main technologies
- [Docker](https://www.docker.com/)
- [PHP](https://www.php.net/)
- [Lumen](https://lumen.laravel.com/)
- [PHPUnit](https://phpunit.de/)
