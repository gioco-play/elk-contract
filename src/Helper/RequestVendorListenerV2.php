<?php
declare(strict_types=1);
namespace GiocoPlus\ELK\Helper;

use GiocoPlus\ELK\Contract\ELKServiceInterface;
use GiocoPlus\ELK\Helper\RequestVendorStruct\RequestStruct;
use GiocoPlus\ELK\Helper\RequestVendorStruct\ResponseStruct;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Psr\Container\ContainerInterface;

class RequestVendorListenerV2 implements ListenerInterface
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
            RequestVendorV2::class,
        ];
    }

    public function process(object $event)
    {
        $this->elk = $this->container->get(ELKServiceInterface::class);
        co(function () use ($event) {
            $this->elk->gfRequestVendorV2(
                $event->opCode,
                $event->vendorCode,
                $event->request,
                $event->response
            );
        });
    }
}