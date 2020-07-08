# Rotas da aplicação

## Listagem de usuários

**URL** : `/api/v1/user-accounts`

**Method** : `GET`

## Success Response

**Code** : `200 OK`

```json
[
  {
    "uuid": "7c480526-7f03-4699-ac9e-c9adab069af6",
    "firstName": "Josué",
    "lastName": "Vasques",
    "document": {
      "number": {
        "clean": "58847214718",
        "masked": "588.472.147-18"
      },
      "type": "cpf"
    },
    "email": "eduardo10@marinho.com",
    "password": "boooo, this is secret data",
    "balance": {
      "integer": 69365,
      "decimal": "693.65"
    },
    "createdAt": {
      "canonical": "2020-07-08 16:11:07",
      "ptBr": "08\/07\/2020 16:11:07"
    },
    "updatedAt": {
      "canonical": null,
      "ptBr": null
    }
  }
]
```

## Criação de usuário 


**URL** : `/api/v1/user-accounts`

**Method** : `POST`

**Fields** : 

```json
{
  "firstName": "Josué",
  "lastName": "Vasques",
  "document": "58847214718",
  "email": "eduardo10@marinho.com",
  "password": "123456"
}
```

## Success Response

**Code** : `201 Created`

```json
{
  "uuid": "7c480526-7f03-4699-ac9e-c9adab069af6",
  "firstName": "Josué",
  "lastName": "Vasques",
  "document": {
    "number": {
      "clean": "58847214718",
      "masked": "588.472.147-18"
    },
    "type": "cpf"
  },
  "email": "eduardo10@marinho.com",
  "password": "boooo, this is secret data",
  "balance": {
    "integer": 69365,
    "decimal": "693.65"
  },
  "createdAt": {
    "canonical": "2020-07-08 16:11:07",
    "ptBr": "08\/07\/2020 16:11:07"
  },
  "updatedAt": {
    "canonical": null,
    "ptBr": null
  }
}
```
