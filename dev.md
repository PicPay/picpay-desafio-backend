# Desafio Back-end PicPay

#### Dependências

* Docker
* Docker compose

#### Execução

Fazer clone deste repositório e executar `docker-composer up`. Após isto, o projeto estárá disponível no endereço `http://127.0.0.1:14000`.

#### Rotas

Para ver todos os detalhes das rotas, consultar a documentação da [API](api.md).

#### Abordagens usadas

* Factory method
* Builder
* DTO
* ORM
* DDD
* SOLID
* Command Pattern
* Escala de centavos para os valores

#### Limitações

* Listagem não tem metadata, filtros, ordenação e paginação.
* No lugar de ORM talvez seria melhor uma outra abordagem ao banco, assim poderia usar cache como redis para melhor performance.

#### Melhorias de design

* Utilização de event sourcing e CQRS para melhor gestão do processo de transferência.
* Validar em blocos se payer e payee existe.
* Validator é precário, colocar inteiro no lugar de string quebra validação.
* Um melhor processo de rollback de transferências.
* Violação do DDD nos comandos por ter dependencia da camada de infra no command.
