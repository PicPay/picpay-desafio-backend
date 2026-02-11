# Exemplos de Uso

## Não uso
Documento aqui que optei por não usar IA na elaboração deste projeto pelo motivo XPTO.

---

## AI Strategy Log

**Tarefa:** Criação de um job para processar pagamentos de uma fila.

- **Prompt:** "Crie uma classe de Job no Laravel chamada `ProcessPayment` que recebe um `paymentId`. O job deve buscar o pagamento, processá-lo e logar o resultado."
  - **Análise:** A IA gerou o job básico. **Aceito.**

- **Prompt:** "Adicione uma política de `retry` a este job. Ele deve tentar 3 vezes com um backoff exponencial começando em 10 segundos."
  - **Análise:** A IA adicionou as propriedades `$tries` e o método `backoff()` corretamente. Isso adiciona resiliência ao fluxo. **Aceito.**

- **Prompt:** "Dentro do método `handle()`, adicione um bloco `try/catch`. Se uma exceção ocorrer, o job deve ser liberado de volta para a fila usando `release()` e um erro deve ser logado."
  - **Análise:** A IA implementou o `try/catch`, mas usou um log genérico. **Modifiquei** para adicionar um log contextualizado com o `paymentId` e a mensagem da exceção, melhorando a observabilidade. A IA entrega o padrão, mas o engenheiro enriquece com o contexto.

---

## Verboso

### 1. Objetivo

Criar um novo endpoint `POST /transactions/debit` que debita um valor da carteira do usuário, garantindo que não ocorram race conditions durante operações concorrentes e que as notificações sejam processadas de forma assíncrona.

### 2. Estratégia de Interação com a IA

1. **Modelagem Inicial:** Solicitar à IA um esqueleto do Controller, Service e Repository para a operação de débito.
2. **Implementação da Trava:** Orientar a IA a implementar um controle de concorrência utilizando `lockForUpdate` no método do repositório que busca e atualiza o saldo.
3. **Simulação de Risco:** Pedir à IA para gerar um teste de integração que simule uma condição de corrida para validar a eficácia do lock.
4. **Otimização Crítica:** Analisar o escopo da transação gerada pela IA e refatorá-la para ser o menor possível, separando a notificação para um job assíncrono.

### 3. Registro de Interações e Decisões Críticas

- **Prompt 1:** "Desenhe a estrutura de classes (Controller, Service, Repository) para um endpoint de débito em uma carteira. O Service deve orquestrar a validação, a atualização de saldo e o envio de uma notificação."
  - **Resultado da IA:** Gerou uma estrutura de classes funcional e bem organizada.
  - **Ação:** **Aceitei a estrutura** como ponto de partida.

- **Prompt 2:** "No método `updateBalance` do `WalletRepository`, adicione um pessimistic lock para evitar race conditions."
  - **Resultado da IA:** Adicionou `->lockForUpdate()` corretamente na query que busca o saldo do usuário.
  - **Ação:** **Aceitei a implementação** do lock.

- **Prompt 3:** "Agora, na classe `TransactionService`, envolva a chamada ao repositório e o envio da notificação dentro de uma `DB::transaction()`."
  - **Resultado da IA:** Criou um closure de transação que englobava tanto a atualização do saldo quanto o dispatch de uma notificação.
  - **Decisão Crítica (Rejeição e Refatoração):** **Rejeitei esta abordagem.** Manter a notificação (uma operação de I/O potencialmente lenta) dentro da transação do banco de dados manteria o lock na linha por tempo demais, degradando a performance do sistema. **Instruí a IA a refatorar:** mover o `dispatch` do job de notificação para *após* o `DB::commit()`. A IA não tem o conhecimento contextual sobre performance em sistemas de alta volumetria para tomar essa decisão sozinha.

### 4. Conclusão

A IA foi fundamental para montar rapidamente a estrutura inicial e a sintaxe do lock. Contudo, a decisão arquitetural mais crítica — **minimizar o escopo da transação do banco de dados para garantir alta concorrência** — exigiu conhecimento sênior e intervenção humana. A IA otimiza a **execução**, mas o engenheiro sênior continua responsável pela **estratégia**.
