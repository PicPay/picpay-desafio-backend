# Desafio Back-end PicPay

Primeiramente, obrigado pelo seu interesse em trabalhar na melhor plataforma de pagamentos do mundo!
Abaixo você encontrará todos as informações necessárias para iniciar o seu teste.

## Avisos antes de começar

-   Crie um repositório no seu GitHub **sem citar nada relacionado ao PicPay**.
-   Faça seus commits no seu repositório.
-   Envie o link do seu repositório para o email **do recrutador responsável**.
-   Você poderá consultar o Google, Stackoverflow ou algum projeto particular na sua máquina.
-   Dê uma olhada nos [Materiais úteis](#materiais-úteis).
-   Dê uma olhada em como será a [entrevista](#para-o-dia-da-entrevista-técnica).
-   Fique à vontade para perguntar qualquer dúvida aos recrutadores.
-   Fique tranquilo, respire, assim como você, também já passamos por essa etapa. Boa sorte! :)

_Corpo do Email com o link do repositório do desafio_

> Seu Nome
>
> Nome do recrutador
>
> Link do repositório
>
> Link do Linkedin

### Sobre o ambiente da aplicação:

-   Escolha qualquer framework que se sinta **confortável** em trabalhar. Esse teste **não faz** nenhuma preferência, portanto decida por aquele com o qual estará mais seguro em apresentar e conversar com a gente na entrevista ;)

-   Você pode, inclusive, não optar por framework nenhum. Neste caso, recomendamos a implementação do serviço via script para diminuir a sobrecarga de criar um servidor web.

-   Ainda assim, se optar por um framework tente evitar usar muito métodos mágicos ou atalhos já prontos. Sabemos que essas facilidades aumentam a produtividade no dia-a-dia mas aqui queremos ver o **seu** código e a sua forma de resolver problemas.

-   Valorizamos uma boa estrutura de containeres criada por você.

## Para o dia da entrevista técnica

Na data marcada pelo recrutador tenha sua aplicação rodando na sua máquina local para execução dos testes e para nos mostrar os pontos desenvolvidos e possíveis questionamentos.
Faremos um code review junto contigo como se você já fosse do nosso time :heart:, você poderá explicar o que você pensou, como arquitetou e como pode evoluir o projeto.

## Objetivo: PicPay Simplificado

Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam transferências entre eles. Vamos nos atentar **somente** ao fluxo de transferência entre dois usuários.

Requisitos:

-   Para ambos tipos de usuário, precisamos do Nome Completo, CPF, e-mail e Senha. CPF/CNPJ e e-mails devem ser únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail.

-   Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.

-   Lojistas **só recebem** transferências, não enviam dinheiro para ninguém.

-   Validar se o usuário tem saldo antes da transferência.

-   Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para simular (https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc).

-   A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o dinheiro deve voltar para a carteira do usuário que envia.

-   No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o envio (https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6).

-   Este serviço deve ser RESTFul.

### Payload

Faça uma **proposta** :heart: de payload, se preferir, temos uma exemplo aqui:

POST /transaction

```json
{
    "value": 100.0,
    "payer": 4,
    "payee": 15
}
```

# Avaliação

Apresente sua solução utilizando o framework que você desejar, justificando a escolha.
Atente-se a cumprir a maioria dos requisitos, pois você pode cumprir-los parcialmente e durante a avaliação vamos bater um papo a respeito do que faltou.

Teremos 2 partes da avaliação:

A correção objetiva será realizada através da utilização de um script de correção automatizada. Você **pode** rodar na sua máquina local ou usar outra ferramenta:

```
docker run -it --rm -v $(pwd):/project -w /project jakzal/phpqa phpmd app text cleancode,codesize,controversial,design,naming,unusedcode
```

A correção qualitativa será durante a entrevista e levará em conta os seguintes critérios:

## O que será avaliado e valorizamos :heart:

-   Documentação
-   Se for para vaga sênior, foque bastante no **desenho de arquitetura**
-   Código limpo e organizado (nomenclatura, etc)
-   Conhecimento de padrões (PSRs, design patterns, SOLID)
-   Ser consistente e saber argumentar suas escolhas
-   Apresentar soluções que domina
-   Modelagem de Dados
-   Manutenibilidade do Código
-   Tratamento de erros
-   Cuidado com itens de segurança
-   Arquitetura (estruturar o pensamento antes de escrever)
-   Carinho em desacoplar componentes (outras camadas, service, repository)

De acordo com os critérios acima, iremos avaliar seu teste para avançarmos para a entrevista técnica.
Caso não tenha atingido aceitavelmente o que estamos propondo acima, não iremos prosseguir com o processo.

## O que NÃO será avaliado :warning:

-   Fluxo de cadastro de usuários e lojistas
-   Frontend (só avaliaremos a (API Restful)[https://www.devmedia.com.br/rest-tutorial/28912])
-   Autenticação

## O que será um Diferencial

-   Uso de Docker
-   Testes de [integração](https://www.atlassian.com/continuous-delivery/software-testing/types-of-software-testing)
-   Testes [unitários](https://www.atlassian.com/continuous-delivery/software-testing/types-of-software-testing)
-   Uso de Design Patterns
-   Documentação
-   Proposta de melhoria na arquitetura

## Materiais úteis

-   https://picpay.com/site/sobre-nos
-   https://hub.packtpub.com/why-we-need-design-patterns/
-   https://refactoring.guru/
-   http://br.phptherightway.com/
-   https://www.php-fig.org/psr/psr-12/
-   https://www.atlassian.com/continuous-delivery/software-testing/types-of-software-testing
-   https://github.com/exakat/php-static-analysis-tools
-   https://martinfowler.com/articles/microservices.htm
-   https://docs.guzzlephp.org/en/stable/request-options.html
-   https://www.devmedia.com.br/rest-tutorial/28912
