## Desafio Back-end PicPay - Instruções para instalação

### Dependências

Docker e docker-compose instalados.

Referências 
1. https://docs.docker.com/get-docker/
2. https://docs.docker.com/compose/install/

### Iniciar os containers do docker através do docker-compose

Em seguida, também na raíz do projeto executar:

1. **cd docker**

2. **docker-compose up --build**


### Realizar o composer install para receber todas as dependências de pacotes

Nao raiz do projeto executar **composer install**

### Copiar configurações

Copiar arquivo **.env.example** para **.env** .

As configurações de acesso ao banco de dados já estão prontas para os dados do docker.

Após o arquivo .env pronto, executar **php artisan key:generate** para gerar a chave do app.

### Executar comando para criar banco de dados

Existe um comando customizado para criar o banco de dados inicial:
**php artisan db:create** que pega as informações do .env e cria o banco.

### Executar migrations e seeds para criar o banco de dados

Executar **php artisan migrate:fresh --seed**

### Corrigir permissões de pastas iniciais

Executar na raíz do projeto:

>sudo chgrp -R www-data storage bootstrap/cache
>
>sudo chmod -R ug+rwx storage bootstrap/cache

Referência: https://laracasts.com/discuss/channels/general-discussion/laravel-framework-file-permission-security

## Acesso e testes

A url principal disponível é: http://127.0.0.1:8080/transaction .

Ao executá-la um dos jobs de autorização é síncrono e fará a autorização em tempo real, mas o job de disparo de e-mails é assíncrono e para rodá-lo (envio de emails) basta executar a fila do laravel:

* php artisan queue:work

Esse processo fará a autorização externa e atualizará a tabela **message_queue**

#### Postman

Existe um arquivo de collection do postman na pasta ****utils/postman** já com algumas sugestões de requisição e o payload pronto.

Referência: https://learning.postman.com/docs/postman/collection-runs/working-with-data-files/


## Laravel

Utilizei a versão 7.0 com php 7.4.

#### Bibliotecas usadas

Seeds (criar baseado no banco): https://github.com/orangehill/iseed

Migrations (criar baseado no banco) : https://github.com/oscarafdev/migrations-generator

## Banco de dados

Utilizei o Mysql 5.7.31

![alt text](https://github.com/edu-lourenco/picpay-desafio-backend/blob/17-07-20/eduardo-lourenco/utils/database/modeloER.png?raw=true)

#### Dados

O projeto já contém seeds para usuários iniciais, 2 comuns e 1 lojista, além da tabela de status.

## Docker

Todo conteúdo está localizado na pasta **docker** na raíz do projeto.
Para permitir persitência de dados do mysql existe uma pasta **mysql-data** dentro do diretório **docker**.
Para o ambiente de desenvolvimento utilizei o docker-compose para controlar os containers. Segue alguns comandos úteis para acessá-los:

* **docker exec -it php7-pp /bin/bash** para acessar o php como ssh.
* **docker exec -it web-pp /bin/bash** para acessar o nginx como ssh.

## Melhorias pendentes 

* Testes unitários e de integração
* Envio de mensagem ao usuário em caso de cancelamento de transação , sugerindo refazê-la.

-------------------------------------------------------------------------

# Desafio Back-end PicPay

Primeiramente, obrigado pelo seu interesse em trabalhar na melhor plataforma de pagamentos do mundo!
Abaixo você encontrará todos as informações necessárias para iniciar o seu teste.

## Avisos antes de começar

- Faça um fork desse repositório para seu usuário
- Crie uma branch a partir da `master` nesse padrão de nomenclatura: dd-mm-yy/nome-sobrenome (por exemplo, 30-04-20/meu-nome)
- Abra o Pull Request até 1 dia antes da entrevista
- Você poderá consultar o Google, Stackoverflow ou algum projeto particular na sua máquina.
- Fique à vontade para perguntar qualquer dúvida aos recrutadores.
- Fique tranquilo, respire, assim como você, também já passamos por essa etapa. Boa sorte! :)

## Setup do projeto

- Framework: Fique a vontade pra usar o framework que quiser
- Subir local ou Docker


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

## O que será avaliado e valorizamos
- Código limpo e organizado
- Ser consistente em suas escolhas
- Apresentar soluções que domina
- Modelagem de Dados
- Manutenibilidade do Código
- Tratamento de erros
- Cuidado com itens de segurança
- Arquitetura (estruturar o pensamento antes de escrever)
- Esboço da arquitetura usando o diagrama da sua escolha

## O que NÃO será avaliado
- Fluxo de cadastro de usuários e lojistas
- Autenticação

## O que será um diferencial
- Uso de Docker
- Testes de [integração](https://www.atlassian.com/continuous-delivery/software-testing/types-of-software-testing)
- Testes [unitários](https://www.atlassian.com/continuous-delivery/software-testing/types-of-software-testing)
- Uso de Design Patters
- Documentação
- Proposta de melhoria na arquitetura


## Para o dia da avaliação
Na data marcada pelo recrutador tenha sua aplicação rodando na sua máquina local **ou** em algum serviço ne web (Ex: [Heroku](https://www.heroku.com/)).


## Materiais úteis
- https://www.php-fig.org/psr/psr-12/
- https://www.atlassian.com/continuous-delivery/software-testing/types-of-software-testing
- https://github.com/exakat/php-static-analysis-tools
- https://martinfowler.com/articles/microservices.html
