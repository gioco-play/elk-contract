<?php
declare(strict_types=1);

namespace GiocoPlus\ELK\Helper;

use GiocoPlus\ELK\Helper\SeamlessWalletRequest;
use GiocoPlus\ELK\Contract\ELKServiceInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Psr\Container\ContainerInterface;

class SeamlessWalletRequestListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var ELKServiceInterface
     */
    protected $elk;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            SeamlessWalletRequest::class
        ];
    }

    public function process(object $event)
    {
        $this->elk = $this->container->get(ELKServiceInterface::class);

        co(function () use ($event) {
            $this->elk->seamlessWalletRequest(
                $event->opCode,
                $event->host,
                $event->path,
                $event->requestParams,
                $event->requestEncrypt,
                $event->requestHeaders,
                method_exists($event->transferStats, 'getTransferTime') ? $event->transferStats->getTransferTime() : '',
                $event->response,
                $event->responseDecrypt,
                $event->transferStats->getResponse()->getHeaders(),
                $event->transferStats->getResponse()->getStatusCode()
            );
        });
    }
}