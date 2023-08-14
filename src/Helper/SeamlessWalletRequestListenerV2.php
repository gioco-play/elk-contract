<?php

namespace GiocoPlus\ELK\Helper;

use GiocoPlus\ELK\Contract\ELKServiceInterface;
use Hyperf\Event\Contract\ListenerInterface;
use Psr\Container\ContainerInterface;

class SeamlessWalletRequestListenerV2 implements ListenerInterface
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
            SeamlessWalletRequestV2::class
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
                $event->requestTime ?? 0,
                $event->response,
                $event->responseDecrypt,
                [],
                $event->respCode ?? 0
            );
        });
    }
}