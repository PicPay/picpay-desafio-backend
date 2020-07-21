
# picpay-desafio-backend
- Essa implementação visa resolver o problema proposto no desafio.

## Análise técnica
Implementei uma carteira monetária simplificada, baseada em transações, a mesma consiste em uma tabela que armazena o pagador e beneficiário e um status. A criação dispara um evento de Notificação com processamento assíncrono e um evento de Autorização com processamento assíncrono.

  
**Notificação assíncrona** - Processa utilizando o sistema listener queues do lumen, com retentativas caso o processo falhe.
- Sucesso - Notifica o pagador e o beneficiário da ação realizada.
- Falha - Tenta 25x a cada 5 segundos - Caso falhe todas, fixa na tabela fail_jobs (Dead letter queue).

**Autorização assíncrona** - Processa utilizando o sistema listener queues do lumen, com retentativas caso o processo falhe.
- Sucesso - Faz a atualização da transação no banco, alterando o status.
- Falha - Faz a atualização da transação no banco de dados, alterando o status da transação e realizando o rollback da da mesma, também notificado os usuários do rollback.

# Documentação técnica

  [Documentação publica Picpay Desafio Backend Leandro Ferreira](https://app.swaggerhub.com/apis/leandrodaf/PicpayDesafioBackendLeandroFerreira/1.0.0)

### Modelo entidade relacionamento

<img src="https://raw.githubusercontent.com/leandrodaf/picpay-desafio-backend/17-07-20/leandro-ferreira/mer.png" width="400">


## Ambientes
Homolog - http://ec2-18-207-140-143.compute-1.amazonaws.com


### Requisitos
- Docker version => 19.03.12
- Docker Compose version => 1.25.0
  
## Comandos make
| Comando | Descrição |
|--|--|
| build | Builda a imagem base de desenvolvimento |
| attach | Acessa o container App onde esta aplicação |
| install | Roda o comando composer install, baixa as dependências do projeto |
| stop | Para a execução de toda a suíte do docker-compose em execução |
| up | Inicia toda a suite de aplicações do docker-compose |
| migrate | Roda todas as database migrations da aplicação |
| mysql-client | Acessa o container mysql do banco de dados da aplicação |
| style-fix | Aplica as regras de padronização de código em toda a aplicação |
| queue-listeners | Starta o processamento das filas assincronas da aplicação |
| jwt-token| Cria um token para a criptografia do jwt da aplicação |

## Executar o projeto
Execute os comandos na sequencia
1. `make up` para iniciar toda a aplicação
2. `make install` para baixar as dependências composer
3. `make migrate` para criar a estrutura do banco de dados
4. `make jwt-token` para gerar um token jwt de criptografia