#  Desafio Back-end PicPay finalizado

### Sobre o ambiente da aplicação:
 o Spring e java 21
    
### Resumo do projeto
Utilizei o padrão Maven, Spring MVC e Spring Data para persistir os dados em um banco de dados em memória, H2. 
Na aplicação, existem apenas dois tipos de usuários: o tipo comum (USER_COMMON), que pode fazer e receber 
transferências, e o lojista (USER_MERCHANT), que apenas recebe transferências. Antes de efetuar a transferência
na classe TransactionService, é verificado se o tipo de usuário está apto a realizar transferências e se o saldo
(balance) é suficiente para a quantia desejada. Se todas as condições forem atendidas, prosseguimos para a segunda
etapa, que é consultar uma API externa: `https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc`. Caso a 
resposta seja negativa, uma exceção será lançada.

Dando continuidade, a próxima etapa envolve o envio de notificações externas.
Para isso, integramos um sistema de notificação (https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6)
que dispara mensagens automáticas para os usuários envolvidos na transação, confirmando a operação ou 
informando sobre qualquer problema que possa ter ocorrido.

   
## Objetivo: PicPay Simplificado

O PicPay Simplificado é uma plataforma de pagamentos simplificada. Nela é possível depositar e realizar transferências
de dinheiro entre usuários. Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam
transferências entre eles.


## Requisitos
- Java 21
- Maven

## Configuração

1. Clone o repositório para sua máquina local usando `git clone https://github.com/superkarlos/picpay-desafio-backend.git`.

## Como executar

1. No terminal, navegue até a pasta raiz do projeto.
2. Execute o comando `mvn clean install` para construir o projeto.
3. Execute o comando `java -jar target/picpay-desafio-backend.jar` para iniciar a aplicação.
4. A aplicação estará rodando em `http://localhost:8080`.

   
## Dependências

- `spring-boot-starter-data-jpa`: Esta é uma dependência inicial do Spring Boot que simplifica a implementação de camadas de persistência de dados usando JPA (Java Persistence API). Ela fornece funcionalidades para criação, leitura, atualização e exclusão de registros em um banco de dados relacional.

- `spring-boot-starter-web`: Esta dependência é usada para construir aplicações web, incluindo RESTful, usando Spring MVC. Ela usa Tomcat como o servidor embutido por padrão.

- `spring-boot-devtools`: Esta dependência é usada para fornecer ferramentas de desenvolvimento úteis, como recarregamento automático de aplicações e configurações de tempo de execução.

- `h2`: H2 é um banco de dados em memória escrito em Java. Ele pode ser incorporado em aplicações Java ou executado no modo cliente-servidor.

- `lombok`: Project Lombok é uma biblioteca java que se conecta automaticamente ao seu editor e ferramentas de construção, reduzindo o código boilerplate, por exemplo, código modelo, como getters, setters e alguns métodos comuns, como `equals`, `hashCode` e `toString`.


- `spring-boot-starter-test`: Esta dependência é usada para testar a aplicação Spring Boot. Ela fornece anotações como `@SpringBootTest` para carregar o contexto da aplicação durante os testes unitários e integração.
## Endpoints da API

Aqui estão alguns dos endpoints disponíveis:

- `GET http://localhost:8080/users`: Retorna uma lista de  usuários cadastrados'.
 
  ![image](https://github.com/superkarlos/picpay-desafio-backend/assets/50372440/f240e878-80aa-48e7-bc40-a45c56485b7f)

- `POST http://localhost:8080/users`: Cria um novo usuário'.
  
- ![image](https://github.com/superkarlos/picpay-desafio-backend/assets/50372440/41a875c3-35ef-4ef6-8385-4728bf9506af)

- `POST http://localhost:8080/transactions`: Cria uma nova transação'.
  
- ![image](https://github.com/superkarlos/picpay-desafio-backend/assets/50372440/26ec1671-9424-4918-9a10-19b5c52193b6)




## Testes

Para executar os testes, use o comando `mvn test` no terminal.


## Atenção

Gostaria de salientar que realizei as validações diretamente. Durante meus testes, o link abaixo não estava retornando nada!

 - Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock para
  simular (https://run.mocky.io/v3/5794d450-d2e2-4412-8131-73d0293ac1cc);

![image](https://github.com/superkarlos/picpay-desafio-backend/assets/50372440/dc7db30f-213f-4908-8c6b-2dedf1353a24)



Gostaria de salientar que realizei as validações diretamente. Durante meus testes, o link abaixo não estava retornando nada!

 - No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um
  serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock para simular o
  envio (https://run.mocky.io/v3/54dc2cf1-3add-45b5-b5a9-6bf7e7f1f4a6);

![image](https://github.com/superkarlos/picpay-desafio-backend/assets/50372440/2abd45ab-9a1b-434a-929a-c43db07edd13)


Habilidades básicas de criação de projetos backend:
- Conhecimentos sobre REST
- Uso do Git
- Capacidade analítica
- Apresentação de código limpo e organizado


## Diferencial
- Documentação
- Ser consistente e saber argumentar suas escolhas
- Apresentar soluções que domina
- Manutenibilidade do Código
- Tratamento de erros
- Cuidado com itens de segurança
- Arquitetura (estruturar o pensamento antes de escrever)
- Carinho em desacoplar componentes (outras camadas, service, repository)
