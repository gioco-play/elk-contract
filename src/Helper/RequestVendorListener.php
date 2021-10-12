<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace GiocoPlus\ELK\Helper;

use GiocoPlus\ELK\Contract\ELKServiceInterface;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Psr\Container\ContainerInterface;

/**
 *
 */
class RequestVendorListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var ELKServiceInterface
     */
    private $elk;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            RequestVendor::class,
        ];
    }

    public function process(object $event)
    {
        $this->elk = $this->container->get(ELKServiceInterface::class);

        co(function () use ($event) {
            $this->elk->gfRequestVendor(
                $event->vendorCode,
                $event->opCode,
                $event->host,
                $event->url,
                $event->request,
                $event->requestTime,
                $event->httpCode,
                $event->header,
                $event->response
            );
        });
    }
}
