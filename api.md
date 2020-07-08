# Rotas da aplicação

## Cobertura de código da aplicação

**URL** : `/coverage/index.html`

**Method** : `GET`

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

## Detalhamento do usuário

**URL** : `/api/v1/user-accounts/{uuid}`

**Method** : `GET`

## Success Response

**Code** : `200 OK`

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

## Detalhamento das transações do usuário

**URL** : `/api/v1/user-accounts/{uuid}/transaction-operations`

**Method** : `GET`

## Success Response

**Code** : `200 OK`

```json
[
  {
    "uuid": "86d3af70-7ed8-4882-84b4-ef02ef0dc6c7",
    "type": "transaction_in",
    "authentication": "BR2608146475084995245737279J6",
    "amount": {
      "integer": 3420,
      "decimal": "34.20"
    },
    "payer": {
      "number": {
        "clean": "58847214718",
        "masked": "588.472.147-18"
      },
      "type": "cpf"
    },
    "payee": {
      "number": {
        "clean": "95490406070",
        "masked": "954.904.060-70"
      },
      "type": "cpf"
    }
  }
]
```
