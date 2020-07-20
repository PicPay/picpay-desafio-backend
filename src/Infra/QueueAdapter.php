<?php

declare(strict_types=1);

namespace Transfer\Infra;

/**
 * Class QueueAdapter
 * @codeCoverageIgnore
 */
class QueueAdapter
{
    //@todo implementar publicação de mensagem na fila
    public function publish(array $payload)
    {
        //enviar mensagem de retentativa pra fila
    }
}
