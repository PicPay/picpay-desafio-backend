# Desafio Back-end PicPay

# Prioridades (Matheus Andrade)

> Geração de API
>
> Geração do DockerFile
>
> Testes realizados através de RestAssured




Primeiramente, obrigado pelo seu interesse em trabalhar na melhor plataforma de pagamentos do mundo!
Abaixo você encontrará todos as informações necessárias para iniciar o seu teste.

## Avisos antes de começar

- Leia com atenção este documento todo e tente seguir ao **máximo** as instruções;
- Crie um repositório no seu GitHub **sem citar nada relacionado ao PicPay**;
- Faça seus commits no seu repositório;
- Envie o link do seu repositório para o email **do recrutador responsável**;
- Você poderá consultar o Google, Stackoverflow ou algum projeto particular na sua máquina;
- Dê uma olhada nos [Materiais úteis](#materiais-úteis);
- Dê uma olhada em como será a [entrevista](#para-o-dia-da-entrevista-técnica);
- Fique à vontade para perguntar qualquer dúvida aos recrutadores;
- Fique tranquilo, respire, assim como você, também já passamos por essa etapa. Boa sorte! :)

_Corpo do Email com o link do repositório do desafio_

> Seu Nome
>
> Nome do recrutador
>
> Link do repositório
>
> Link do Linkedin

### Sobre o ambiente da aplicação:

- Escolha qualquer framework que se sinta **confortável** em trabalhar. Esse teste **não faz** nenhuma preferência,
  portanto decida por aquele com o qual estará mais seguro em apresentar e conversar com a gente na entrevista ;)

- Você pode, inclusive, não optar por framework nenhum. Neste caso, recomendamos a implementação do serviço via script
  para diminuir a sobrecarga de criar um servidor web;

- Ainda assim, se optar por um framework tente evitar usar muito métodos mágicos ou atalhos já prontos. Sabemos que
  essas facilidades aumentam a produtividade no dia-a-dia mas aqui queremos ver o **seu** código e a sua forma de
  resolver problemas;

> Valorizamos uma boa estrutura de containeres criada por você.

## Para o dia da entrevista técnica

Na data marcada pelo recrutador tenha sua aplicação rodando na sua máquina local para execução dos testes e para nos
mostrar os pontos desenvolvidos e possíveis questionamentos.
Faremos um code review junto contigo como se você já fosse do nosso time :heart:, você poderá explicar o que você
pensou, como arquitetou e como pode evoluir o projeto.

## Objetivo: PicPay Simplificado

O PicPay Simplificado é uma plataforma de pagamentos simplificada. Nela é possível depositar e realizar transferências
de dinheiro entre usuários. Temos 2 tipos de usuários, os comuns e lojistas, ambos têm carteira com dinheiro e realizam
transferências entre eles.

### Requisitos

A seguir estão algumas regras de negócio que são importantes para o funcionamento do PicPay Simplificado:

- Para ambos tipos de usuário, precisamos do `Nome Completo`, `CPF`, `e-mail` e `Senha`. CPF/CNPJ e e-mails devem ser
  únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail;

- Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários;

- Lojistas **só recebem** transferências, não enviam dinheiro para ninguém;

- Validar se o usuário tem saldo antes da transferência;

- Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock
  [https://util.devi.tools/api/v2/authorize](https://util.devi.tools/api/v2/authorize) para simular o serviço
  utilizando o verbo `GET`;

- A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o
  dinheiro deve voltar para a carteira do usuário que envia;

- No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um
  serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock
  [https://util.devi.tools/api/v1/notify)](https://util.devi.tools/api/v1/notify)) para simular o envio da notificação
  utilizando o verbo `POST`;

- Este serviço deve ser RESTFul.

> Tente ser o mais aderente possível ao que foi pedido, mas não se preocupe se não conseguir atender a todos os
> requisitos. Durante a entrevista vamos conversar sobre o que você conseguiu fazer e o que não conseguiu.

### Endpoint de transferência

Você pode implementar o que achar conveniente, porém vamos nos atentar **somente** ao fluxo de transferência entre dois
usuários. A implementação deve seguir o contrato abaixo.

```http request
POST /transfer
Content-Type: application/json

{
  "value": 100.0,
  "payer": 4,
  "payee": 15
}
```

Caso ache interessante, faça uma **proposta** de endpoint e apresente para os entrevistadores :heart:

# Avaliação

Apresente sua solução utilizando o framework que você desejar, justificando a escolha.
Atente-se a cumprir a maioria dos requisitos, pois você pode cumprir-los parcialmente e durante a avaliação vamos bater
um papo a respeito do que faltou.

## O que será avaliado e valorizamos :heart:

Habilidades básicas de criação de projetos backend:
- Conhecimentos sobre REST
- Uso do Git
- Capacidade analítica
- Apresentação de código limpo e organizado

Conhecimentos intermediários de construção de projetos manuteníveis:
- Aderência a recomendações de implementação como as PSRs
- Aplicação e conhecimentos de SOLID
- Identificação e aplicação de Design Patterns
- Noções de funcionamento e uso de Cache
- Conhecimentos sobre conceitos de containers (Docker, Podman etc)
- Documentação e descrição de funcionalidades e manuseio do projeto
- Implementação e conhecimentos sobre testes de unidade e integração
- Identificar e propor melhorias
- Boas noções de bancos de dados relacionais

Aptidões para criar e manter aplicações de alta qualidade:
- Aplicação de conhecimentos de observabilidade
- Utlização de CI para rodar testes e análises estáticas
- Conhecimentos sobre bancos de dados não-relacionais
- Aplicação de arquiteturas (CQRS, Event-sourcing, Microsserviços, Monolito modular)
- Uso e implementação de mensageria
- Noções de escalabilidade
- Boas habilidades na aplicação do conhecimento do negócio no software
- Implementação margeada por ferramentas de qualidade (análise estática, PHPMD, PHPStan, PHP-CS-Fixer etc)
- Noções de PHP assíncrono

### Boas práticas

Caso use PHP tente seguir as [PSRs](https://www.php-fig.org/psr/psr-12/), caso use outro framework ou linguagem, tente
seguir as boas práticas da comunidade.

Uma sugestão para revisar a qualidade do seu código é usar ferramentas como o PHPMD antes de submeter o seu teste.
O comando a seguir pode ser usado para rodar o PHPMD no seu projeto localmente, por exemplo:
```bash
docker run -it --rm -v $(pwd):/project -w /project jakzal/phpqa phpmd app text cleancode,codesize,controversial,design,naming,unusedcode
```

## O que NÃO será avaliado :warning:

- Fluxo de cadastro de usuários e lojistas
- Frontend (só avaliaremos a (API Restful)[https://www.devmedia.com.br/rest-tutorial/28912])
- Autenticação

## O que será um Diferencial

- Uso de Docker
- Uma cobertura de testes consistente
- Uso de Design Patterns
- Documentação
- Proposta de melhoria na arquitetura
- Ser consistente e saber argumentar suas escolhas
- Apresentar soluções que domina
- Modelagem de Dados
- Manutenibilidade do Código
- Tratamento de erros
- Cuidado com itens de segurança
- Arquitetura (estruturar o pensamento antes de escrever)
- Carinho em desacoplar componentes (outras camadas, service, repository)

## Materiais úteis

- https://picpay.com/site/sobre-nos
- https://hub.packtpub.com/why-we-need-design-patterns/
- https://refactoring.guru/
- http://br.phptherightway.com/
- https://www.php-fig.org/psr/psr-12/
- https://www.atlassian.com/continuous-delivery/software-testing/types-of-software-testing
- https://github.com/exakat/php-static-analysis-tools
- https://martinfowler.com/articles/microservices.html
- https://docs.guzzlephp.org/en/stable/request-options.html
- https://www.devmedia.com.br/rest-tutorial/28912
- 


## Uso/Exemplos

```java

package br.com.picpay.service.modelos;

import br.com.picpay.dto.PessoaDTO;
import io.restassured.http.ContentType;
import org.junit.jupiter.api.BeforeEach;
import org.junit.jupiter.api.DisplayName;
import org.junit.jupiter.api.Test;


import java.util.List;

import static br.com.picpay.datafactory.PessoaData.pessoaComum;
import static br.com.picpay.datafactory.PessoaData.pessoaLojista;
import static br.com.picpay.util.Util.PATH;
import static br.com.picpay.util.Util.URL;
import static io.restassured.RestAssured.*;

import static org.hamcrest.Matchers.*;

@DisplayName("Testes de API Rest Módulo de Pessoa")
public class PessoaComumLojistaTest {


    private int randomInt = (int) (Math.random() * 10);

    @BeforeEach
    public void inicializarCasosDeTeste() {
        basePath = PATH;
        baseURI = URL;
    }

    @Test
    @DisplayName("Insercao de Pessoa Comum")
    public void inserirPessoaComum() {

        given()
                .contentType(ContentType.JSON)
                .body(pessoaComum(randomInt))
                .when()
                .post("inserirPessoa")
                .then()
                .assertThat()
                .body(equalTo("Pessoa adicionada com sucesso"))
                .statusCode(201);
    }

    @Test
    @DisplayName("Insercao de Pessoa Lojista")
    public void inserirPessoaLojista() {

        given()
                .contentType(ContentType.JSON)
                .body(pessoaLojista(randomInt))
                .when()
                .post("inserirPessoa")
                .then()
                .assertThat()
                .body(equalTo("Pessoa adicionada com sucesso"))
                .statusCode(201);
    }

    @Test
    @DisplayName("Depositar Dinheiro Conta de Pessoa Comum")
    //-- Dados inseridos primeiro para pessoa comum
    public void inserirDepositoPessoaComum() {

        List<PessoaDTO> pessoaList = given()
                .contentType(ContentType.JSON)
                .when()
                .get("listarTodosDadosUsuarios")
                .then()
                .assertThat()
                .statusCode(200)
                .extract()
                .jsonPath()
                .getList("", PessoaDTO.class)
                .stream()
                .filter(pessoaDTO -> pessoaDTO.getCpfPessoaDTO() != null && pessoaDTO.getCpfPessoaDTO().getCpfPessoaComum() != null).toList();
        //-- Depositar so para uma devida pessoa. Com o break ou so pela devida pesquisa.
        //List<PessoaDTO> pessoaDTO = pessoaList.stream().filter(p -> p.getCpfPessoaDTO().getCpfPessoaComum() != null).toList();
        for (PessoaDTO pessoaDTON : pessoaList) {

            String pessoaComumCPF01 = pessoaDTON.getCpfPessoaDTO().getCpfPessoaComum();

            double valorDeposito = (randomInt * 1000);

            given()
                    .contentType(ContentType.JSON)
                    .when()
                    //depositarDinheiroPessoaComum/{pessoacpfemissor}/{valordedeposito}
                    .post("depositarDinheiroPessoaComum/" + pessoaComumCPF01 + "/" + valorDeposito)
                    .then()
                    .assertThat()
                    .body(equalTo("Dinheiro adicionado com sucesso"))
                    .statusCode(201);

            break;

        }
    }

    @Test
    @DisplayName("Listar de Pessoas")
    public void listarPessoaComumLojista() {

        List<PessoaDTO> listarPessoas = given()
                .contentType(ContentType.JSON)
                .when()
                .get("listarTodosDadosUsuarios")
                .then()
                .assertThat()
                .statusCode(200)
                .extract()
                .path("");

        System.out.println(listarPessoas.stream().toList());
    }

    @Test
    @DisplayName("Inserir Transferencia Pessoa Comum")
    // -- Listar todos as pessoas: Comum e Lojista, em seguida identifica a primeira pessoa comum, e a ultima pessoa Comum. Logo apos transfere dinheiro para a ultima pessoa Comum
    public void transeferirDinheiroPessoaComum() {

        List<PessoaDTO> listarPessoas = given()
                .contentType(ContentType.JSON)
                .when()
                .get("listarTodosDadosUsuarios")
                .then()
                .assertThat()
                .statusCode(200)
                .extract()
                .jsonPath()
                .getList("", PessoaDTO.class)
                .stream()
                //-- Filtrar pessoas com o CPF
                .filter(pessoaDTO -> pessoaDTO.getCpfPessoaDTO() != null
                        && pessoaDTO.getCpfPessoaDTO().getCpfPessoaComum() != null
                        && pessoaDTO.getCnpjPessoaDTO() == null || pessoaDTO.getCnpjPessoaDTO().getCnpjPessoaLojista() == null).toList();

        String pessoaComumCPF01 = "", pessoaComumCPF02 = "";

        double valorTransferencia = 1500.0;

        //-- Informar a primeira pessoa
        pessoaComumCPF01 = listarPessoas.getFirst().getCpfPessoaDTO().getCpfPessoaComum();
        //-- Informar a segunda pessoa
        pessoaComumCPF02 = listarPessoas.getLast().getCpfPessoaDTO().getCpfPessoaComum();

        given()
                .contentType(ContentType.JSON)
                .when()
                //---transferenciaPessoaComum/{pessoacpfemissor}/{pessoacpfreceptor}/{valortransferencia}
                .post("transferenciaPessoaComum?pessoacpfemissor=" + pessoaComumCPF01 + "&pessoacpfreceptor=" + pessoaComumCPF02 + "&valortransferencia=" + valorTransferencia)
                .then()
                .assertThat()
                .statusCode(201)
                .body("emissor", equalTo(pessoaComumCPF01))
                .body("receptor", equalTo(pessoaComumCPF02))
                .body("valorTransferencia", equalTo((float) valorTransferencia));
    }

    @Test
    @DisplayName("Inserir Transferencia Pessoa Lojista")
    // -- Listar todos as pessoas: Comum e Lojista, em seguida identifica a primeira pessoa comum, e a primeira pessoa Lojista. Logo apos transfere dinheiro para a primeira pessoa Lojista
    public void transeferirDinheiroPessoaComumParaLojista() {

        List<PessoaDTO> listarPessoas = given()
                .contentType(ContentType.JSON)
                .when()
                .get("listarTodosDadosUsuarios")
                .then()
                .assertThat()
                .statusCode(200)
                .extract()
                .jsonPath()
                .getList("", PessoaDTO.class)
                .stream()
                //-- Filtrar pessoas com o CPF e com o CNPJ
                .toList();
        String pessoaComumCPF = "", pessoaLojista = "";

        double valorTransferencia = 1500.0;

        //-- Informar a primeira pessoa -- Comum 1º
        pessoaComumCPF = listarPessoas
                .stream()
                .filter(pessoaDTO -> pessoaDTO.getCpfPessoaDTO() != null && pessoaDTO.getCpfPessoaDTO().getCpfPessoaComum() != null)
                .findFirst()
                .get()
                .getCpfPessoaDTO()
                .getCpfPessoaComum();
        //-- Informar a segunda pessoa -- Lojista 1º
        pessoaLojista = listarPessoas
                .stream()
                .filter(pessoaDTO -> pessoaDTO.getCnpjPessoaDTO() != null && pessoaDTO.getCnpjPessoaDTO().getCnpjPessoaLojista() != null)
                .findFirst()
                .get()
                .getCnpjPessoaDTO()
                .getCnpjPessoaLojista();

        //String pessoaLojistaEncoded = URLEncoder.encode(pessoaLojista, StandardCharsets.UTF_8);

        //@PostMapping("transferenciaParaPessoaLojista/{pessoacpfemissor}/{pessoacnpj}/{valortransferencia}")
        given()
                .contentType(ContentType.JSON)
                .when()
                .post("transferenciaParaPessoaLojista?pessoacpfemissor=" + pessoaComumCPF + "&pessoacnpj=" + pessoaLojista + "&valortransferencia=" + valorTransferencia)
                .then()
                .assertThat()
                .statusCode(201)
                .body("emissor", equalTo(pessoaComumCPF))
                .body("receptor", equalTo(pessoaLojista))
                .body("valorTransferencia", equalTo((float) valorTransferencia));
    }

}

```


