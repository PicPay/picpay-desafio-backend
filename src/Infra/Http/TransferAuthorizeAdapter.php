<?php

declare(strict_types=1);

namespace Transfer\Infra\Http;

/**
 * Class TransferAuthorizeAdapter
 * @package Transfer\Infra\Http
 */
class TransferAuthorizeAdapter
{
    /**
     * @var Adapter
     */
    private Adapter $authorizeAdapter;

    /**
     * @var string
     */
    private string $url;

    /**
     * TransferAuthorizeAdapter constructor.
     * @param Adapter $authorizeAdapter
     * @param string $url
     */
    public function __construct(Adapter $authorizeAdapter, string $url)
    {
        $this->authorizeAdapter = $authorizeAdapter;
        $this->url = $url;
    }

    /**
     * @return Response
     */
    public function request(): Response
    {
       return $this->authorizeAdapter->request($this->url);
    }
}
