# Desafio Back-end PicPay - Projeto Base para Entrevista

Primeiramente, obrigado pelo seu interesse em trabalhar na melhor plataforma de pagamentos do mundo!

## Sobre este projeto

Este é um **projeto base** que você deve estudar **antes da sua entrevista técnica**. Durante a entrevista, faremos um *
*live coding** em cima deste código, onde você terá a oportunidade de demonstrar suas habilidades técnicas e propor
melhorias.

### O que é este projeto?

Um **mini PicPay** desenvolvido em **Laravel 12** com funcionalidades básicas de transferência entre usuários. O projeto
contém implementações propositalmente simplificadas e pontos de melhoria que serão discutidos durante a entrevista.

## Avisos importantes

- **Estude o código com antecedência**: Reserve tempo para entender a estrutura, fluxos e tecnologias utilizadas;
- **Não é necessário fazer alterações antes da entrevista**: Vamos trabalhar juntos durante o live coding;
- **Prepare-se para discutir**: Arquitetura, melhorias, design patterns, testes, segurança e boas práticas;
- **Tenha o ambiente funcionando**: Certifique-se de conseguir rodar o projeto localmente antes da entrevista;
- **Fique à vontade para fazer anotações**: Identifique pontos que você mudaria ou melhoraria;
- **Fique tranquilo**: A entrevista é uma conversa técnica, queremos conhecer sua forma de pensar e resolver problemas.

## Requisitos para rodar o projeto

- **Docker** e **Docker Compose** instalados
- **Git** para clonar o repositório
- **Make** (já vem instalado no Linux/Mac, no Windows use WSL)

## Como configurar e rodar o projeto

### 1. Clone o repositório

```bash
git clone https://github.com/PicPay/picpay-desafio-backend.git
cd picpay-desafio-backend
git checkout -B laravel-12 origin/laravel-12
```

### 2. Execute o setup completo

```bash
make setup
```

Este comando irá:

- Criar o arquivo `.env` baseado no `.env.example`
- Buildar os containers Docker
- Instalar as dependências do PHP (Composer)
- Instalar as dependências do frontend (NPM)
- Gerar a chave da aplicação
- Criar o banco de dados SQLite
- Executar as migrations
- Subir os containers

### 3. Acesse a aplicação

Após o setup, a aplicação estará disponível em:

- **WEB/API**: http://localhost:8080

### 4. Comandos úteis

```bash
# Parar os containers
make stop

# Rodar os testes
make test

# Rodar análise estática e qualidade de código
make ci

# Corrigir code style
make fix

# Acessar o container da aplicação
make container

# Executar comandos Artisan
make artisan <comando>

# Ver todos os comandos disponíveis
make help
```

## Sobre o PicPay Simplificado

O projeto implementa uma plataforma de pagamentos simplificada.

### Requisitos

A seguir estão algumas regras de negócio importantes para o funcionamento do PicPay Simplificado:

- [ ] Para ambos tipos de usuário, precisamos do `Nome Completo`, `CPF`, `e-mail` e `Senha`. CPF/CNPJ e e-mails devem ser
  únicos no sistema. Sendo assim, seu sistema deve permitir apenas um cadastro com o mesmo CPF ou endereço de e-mail;
- [ ] Usuários podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários;
- [ ] Lojistas **só recebem** transferências, não enviam dinheiro para ninguém;
- [ ] Validar se o usuário tem saldo antes da transferência;
- [ ] Antes de finalizar a transferência, deve-se consultar um serviço autorizador externo, use este mock
  [https://util.devi.tools/api/v2/authorize](https://util.devi.tools/api/v2/authorize) para simular o serviço
  utilizando o verbo `GET`;
- [ ] A operação de transferência deve ser uma transação (ou seja, revertida em qualquer caso de inconsistência) e o
  dinheiro deve voltar para a carteira do usuário que envia;
- [ ] No recebimento de pagamento, o usuário ou lojista precisa receber notificação (envio de email, sms) enviada por um
  serviço de terceiro e eventualmente este serviço pode estar indisponível/instável. Use este mock
  [https://util.devi.tools/api/v1/notify)](https://util.devi.tools/api/v1/notify)) para simular o envio da notificação
  utilizando o verbo `POST`;
- [ ] Este serviço deve ser RESTFul.

## Estrutura do projeto

```
app/
├── Http/Controllers/    # Controllers da API
├── Models/             # Models Eloquent
├── Services/           # Lógica de negócio
├── Repositories/       # Acesso aos dados
└── ...

database/
├── migrations/         # Migrations do banco
└── seeders/           # Seeders de exemplo

tests/
├── Unit/              # Testes unitários
└── Feature/           # Testes de integração
```

## Para o dia da entrevista técnica

### O que esperar

Durante a entrevista, faremos um **code review interativo** e **live coding** onde:

1. **Você explicará** partes do código e suas decisões
2. **Discutiremos** pontos de melhoria e refatorações
3. **Faremos pair programming** para implementar melhorias juntos
4. **Conversaremos** sobre arquitetura, patterns e boas práticas
5. **Você poderá demonstrar** seu conhecimento técnico na prática

### Tenha em mente

- Como você estruturaria melhor o código?
- Quais design patterns você aplicaria?
- Como melhoraria a testabilidade?
- Que aspectos de segurança você observou?
- Como tornaria o código mais manutenível?
- Quais seriam suas preocupações com desempenho e escalabilidade?

## O que será avaliado

Durante a entrevista técnica, avaliaremos sua capacidade de:

### Análise e pensamento crítico
- Identificar pontos fortes e fracos do código existente
- Propor melhorias fundamentadas
- Justificar suas decisões técnicas
- Pensar em soluções alternativas para os problemas apresentados

### Conhecimento técnico
- Demonstrar domínio das tecnologias utilizadas
- Aplicar boas práticas e princípios de desenvolvimento
- Considerar aspectos de qualidade, manutenibilidade e evolução do código

### Habilidades práticas
- Capacidade de implementar melhorias durante o pair programming
- Comunicação clara de ideias técnicas
- Trabalho colaborativo

**Dica**: Explore o projeto com curiosidade! Identifique o que você faria diferente, o que melhoraria e o que manteria. Estamos interessados em conhecer sua forma de pensar e resolver problemas.

## Ferramentas de qualidade implementadas

O projeto já conta com várias ferramentas configuradas:

```bash
# Pint (Laravel Code Style)
make lint

# PHPStan (Análise estática)
composer test:types

# Rector (Refatoração automatizada)
composer test:refacto

# PHPMD (Mess Detector)
composer test:mess

# Executar tudo
make ci
```

## Pontos de atenção

Este projeto contém **intencionalmente** alguns pontos que podem ser melhorados. Durante a entrevista, você terá a oportunidade de identificá-los e discuti-los conosco.

Sugestão: Analise o código pensando em cenários reais de produção e identifique oportunidades de melhoria.

## Materiais úteis para estudo

- [Laravel 12 Documentation](https://laravel.com/docs/12.x)
- [PHP The Right Way](http://br.phptherightway.com/)
- [PSR-12: Extended Coding Style](https://www.php-fig.org/psr/psr-12/)
- [Refactoring Guru - Design Patterns](https://refactoring.guru/)
- [SOLID Principles](https://www.digitalocean.com/community/conceptual_articles/s-o-l-i-d-the-first-five-principles-of-object-oriented-design)
- [REST API Best Practices](https://www.devmedia.com.br/rest-tutorial/28912)
- [Testing Best Practices](https://www.atlassian.com/continuous-delivery/software-testing/types-of-software-testing)

## Dúvidas?

Se tiver qualquer problema para rodar o projeto ou dúvidas sobre o processo, entre em contato com o recrutador
responsável.

**Boa sorte e até a entrevista! 🚀**
