<?php

declare(strict_types=1);

namespace Transfer\Infra\Http;

use Psr\Http\Message\ResponseInterface as Response;

/**
 * Interface Http
 * @package Transfer\Infra\Http
 */
interface Http
{
    /**
     * @param string $method
     * @param string $uri
     * @param array $Options
     * @return Response
     */
    public function request(string $method, string $uri, array $Options = []);

}
