<?php

declare(strict_types=1);

namespace Transfer\Infra\Http;

/**
 * Class TransferAuthorizeAdapter
 * @package Transfer\Infra\Http
 */
class TransferNotificationAdapter
{
    /**
     * @var Adapter
     */
    private Adapter $notificationAdapter;

    /**
     * @var string
     */
    private string $url;

    /**
     * TransferNotificationAdapter constructor.
     * @param Adapter $notificationAdapter
     * @param string $url
     */
    public function __construct(Adapter $notificationAdapter, string $url)
    {
        $this->notificationAdapter = $notificationAdapter;
        $this->url = $url;
    }

    /**
     * @return Response
     */
    public function request(): Response
    {
        return $this->notificationAdapter->request($this->url);
    }
}
