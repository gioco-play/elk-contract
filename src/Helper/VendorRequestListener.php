<?php

declare(strict_types=1);
namespace GiocoPlus\ELK\Helper;


use GiocoPlus\ELK\Helper\VendorRequest;
use GiocoPlus\ELK\Contract\ELKServiceInterface;
use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

class VendorRequestListener implements ListenerInterface
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
            VendorRequest::class
        ];
    }

    public function process(object $event)
    {
        $this->elk = $this->container->get(ELKServiceInterface::class);

        co(function() use ($event) {
            $requestPath = $event->requestPath;
            $requestMethod = $event->requestMethod;
            $requestParams = json_encode($event->requestParams, JSON_UNESCAPED_UNICODE);
            $requestHeaders = json_encode($event->requestHeaders, JSON_UNESCAPED_UNICODE);
            $execStart = $event->execStart;

//            var_dump($event->response);
//            var_dump($event->$requestHeader);

//            $this->elk->vendorRequestGF(
//                $event->vendorCode,
//                $requestPath,
//                [
//                    "data" => $requestParams,
//                    "method" => $requestMethod,
//                    "headers" => $requestHeaders
//                ],
//                $event->responseArr,
//                (micro_timestamp() - $execStart) / 1000,
//                micro_timestamp()
//            );

            $this->elk->vendorRequestGF(
                $event->vendorCode,
                $requestPath,
                $requestParams,
                $requestMethod,
                $requestHeaders,
                (micro_timestamp() - $execStart) / 1000,
                $event->response,
                $event->responseOther
            );
        });
    }
}