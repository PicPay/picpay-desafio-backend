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

## Error Responses

**Code** : `422 Unprocessable Entity`

```json
{
  "errors": [
    "Account with document [ cpf:58847214718 ] can not be created, already exists"
  ]
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

## Error Responses

**Code** : `404 Not Found`

```json
{
  "errors": [
    "Account with uuid [ 7c480526-7f03-4699-ac9e-c9adab069af6 ] not found"
  ]
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

## Error Responses

**Code** : `404 Not Found`

```json
{
  "errors": [
    "Account with uuid [ 7c480526-7f03-4699-ac9e-c9adab069af6 ] not found"
  ]
}
```

## Criação de uma transferência 

**URL** : `/api/v1/transactions`

**Method** : `POST`

**Fields** : 

```json
{
  "payerUuid": "86d3af70-7ed8-4882-84b4-ef02ef0dc6c7",
  "payeeUuid": "9ddc63b1-2996-43be-af9f-4bb67d3cb670",
  "amount": 1250
}
```

## Success Response

**Code** : `201 Created`

```json
{
  "uuid": "5007ecb0-ebec-4f67-b482-2a86ec069daf",
  "accountPayer": {
    "id": "86d3af70-7ed8-4882-84b4-ef02ef0dc6c7",
    "document": {
      "number": {
        "clean": "58847214718",
        "masked": "588.472.147-18"
      },
      "type": "cpf"
    }
  },
  "accountPayee": {
    "id": "9ddc63b1-2996-43be-af9f-4bb67d3cb670",
    "document": {
      "number": {
        "clean": "66450303042",
        "masked": "664.503.030-42"
      },
      "type": "cpf"
    }
  },
  "amount": {
    "integer": 1250,
    "decimal": "12.50"
  },
  "authentication": "BR7053616506301807045297437N8",
  "createdAt": {
    "canonical": "2020-07-08 09:51:22",
    "ptBr": "08\/07\/2020 09:51:22"
  }
}
```

## Error Responses

**Code** : `422 Unprocessable Entity`

```json
{
  "errors": [
    "Account with type [ payer ] and uuid [ 86d3af70-7ed8-4882-84b4-ef02ef0dc6c7 ] not found"
  ]
}
```

**Code** : `422 Unprocessable Entity`

```json
{
  "errors": [
    "Account with type [ payee ] and uuid [ 9ddc63b1-2996-43be-af9f-4bb67d3cb670 ] not found"
  ]
}
```

**Code** : `422 Unprocessable Entity`

```json
{
  "errors": [
    "Invalid payer account, this account [ 86d3af70-7ed8-4882-84b4-ef02ef0dc6c7 ] is commercial establishment  and can not do transfer to other accounts"
  ]
}
```

**Code** : `422 Unprocessable Entity`

```json
{
  "errors": [
    "Insufficient balance in payer account to do money transfer, balance [ 0 ], required to transfer [ 100 ]"
  ]
}
```


**Code** : `418 I'm a teapot`

```json
{
  "errors": [
    "Seu bobinho, você não pode fazer uma transferência para si mesmo :)"
  ]
}
```

**Code** : `500 Internal Server Error`

```json
{
  "errors": [
    "Any internal error"
  ]
}
```

## Listagem de transferências

**URL** : `/api/v1/transactions`

**Method** : `GET`

## Success Response

**Code** : `200 OK`

```json
[
  {
    "uuid": "5007ecb0-ebec-4f67-b482-2a86ec069daf",
    "accountPayer": {
      "id": "86d3af70-7ed8-4882-84b4-ef02ef0dc6c7",
      "document": {
        "number": {
          "clean": "58847214718",
          "masked": "588.472.147-18"
        },
        "type": "cpf"
      }
    },
    "accountPayee": {
      "id": "9ddc63b1-2996-43be-af9f-4bb67d3cb670",
      "document": {
        "number": {
          "clean": "66450303042",
          "masked": "664.503.030-42"
        },
        "type": "cpf"
      }
    },
    "amount": {
      "integer": 1250,
      "decimal": "12.50"
    },
    "authentication": "BR7053616506301807045297437N8",
    "createdAt": {
      "canonical": "2020-07-08 09:51:22",
      "ptBr": "08\/07\/2020 09:51:22"
    }
  }
]
```
