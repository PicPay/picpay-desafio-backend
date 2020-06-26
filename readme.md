# Desafio Back-end PicPay

Primeiramente, obrigado pelo seu interesse em trabalhar na melhor plataforma de pagamentos do mundo!
Abaixo você encontrará todos as informações necessárias para iniciar o seu teste.


## Mudancas / implementacoes
 * Upgrade do lumen e das dependencias para ultima versao
 * Migrations e seeder com o projeto
 * comandos para testar
    - composer test
    - composer migrate:seed

 * Implementado
    - funcionalidades exigida
    - /api/v1/transaction endpoint
    - banco de dados no MySQL
    - Testes unitarios / integracao da rota
 * Arquitetura
    - utilizei o padrao de eventos do Lumen / Laravel
        onde transferir um valor dispara um evento `TransactionEvent`
        e a partir disso encadeia uma série de execuçoes, validacoes e notificacoes.
        Somente quando todo o fluxo ocorreu bem, finaliza a transacao (tabela transaction),
        caso contrário retorna erro para a rota
    - Utilizado Guzzle para acessar os endpoints
    - Projeto no docker
    - Usando os recursos do Lumen
        - validation / request / event / test / eloquent / Http dentre outros.

Obrigado pelo tempo! =)

## Avisos antes de começar

- Primeiro crie uma branch a partir da `master` nesse padrão de nomenclatura: dd-mm-yy/nome-sobrenome (por exemplo, 30-04-20/meu-nome)
- Você poderá consultar o Google, Stackoverflow ou algum projeto particular na sua máquina.
- Fique à vontade para perguntar qualquer dúvida aos recrutadores.
- Fique tranquilo, respire, assim como você, também já passamos por essa etapa. Boa sorte! :)

## Setup do projeto

- Lumen 7.0
- PHP > 7.2

## Como Rodar

- Instale o [Docker](https://docs.docker.com/get-docker/)
- Execute `docker-compose up -d`
- Execute `docker exec -it api.desafio.dev php artisan key:generate` 
- A Aplicação estará disponível na porta `http://localhost:8000/`

## Objetivo - PicPay Simplificado

Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam transferências entre eles. Vamos nos atentar **somente** ao fluxo de transferência entre dois usuários.

Requisitos:

- Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.

- Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários. 

- Lojistas **só recebem** transferências, não enviam dinheiro para ninguém.

- Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular (https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6).

- A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia. 

- No recebimento de pagamento, o usuário ou lojista precisa receber notificação enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o envio (https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04). 



### Payload

POST /transaction

```json
{
    "value" : 100.00,
    "payer" : 4,
    "payee" : 15
}
```


# Avaliação

Caso você não se sinta à vontade com a arquitetura proposta, você pode apresentar sua solução utilizando frameworks diferentes.
Atente-se a cumprir a maioria dos requisitos, pois você pode cumprir-los parcialmente e durante a avaliação vamos bater um papo a respeito do que faltou.

Teremos 2 partes da avaliação:
A correção objetiva será realizada através da utilização de um script de correção automatizada.
A correção qualitativa será durante a entrevista e levará em conta os seguintes critérios:

## O que será avaliado
- Arquitetura
- Domínio do Framework
- Domínio da Linguagem
- Modelagem de Dados
- Legibilidade do Código
- Estrutura do Código
- Organização do Código
- Manutenibilidade do Código
- Tratamento de erros
- Cuidado com itens de segurança
- Esboço da arquitetura usando o diagrama da sua escolha

## O que NÃO será avaliado
- Fluxo de cadastro de usuários e lojistas
- Autenticação

## O que será um diferencial
- Testes de [integração](https://www.atlassian.com/continuous-delivery/software-testing/types-of-software-testing)
- Testes [unitários](https://www.atlassian.com/continuous-delivery/software-testing/types-of-software-testing)
- Uso de Design Patters
- Proposta de melhoria na arquitetura


## Para o dia da avaliação
Na data marcada pelo recrutador tenha sua aplicação rodando na sua máquina local **ou** em algum serviço ne web (Ex: [Heroku](https://www.heroku.com/)).

## Documentação Laravel

https://laravel.com/docs

## Sugestões de estudo

- https://laracasts.com

- https://www.php-fig.org/psr/psr-12/

