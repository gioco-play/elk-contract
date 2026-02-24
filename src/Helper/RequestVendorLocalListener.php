<?php
declare(strict_types=1);
namespace GiocoPlus\ELK\Helper;

use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use Psr\Container\ContainerInterface;

class RequestVendorLocalListener implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            RequestVendorLocal::class,
        ];
    }

    public function process(object $event)
    {
        if ($event instanceof RequestVendorLocal) {
            $logData = [
                'operator_code' => $event->opCode,
                'vendor_code' => $event->vendorCode,
                'host' => $event->request->host,
                'path' => $event->request->path,
                'request' => [
                    'body' => json_encode($event->request->params, JSON_UNESCAPED_UNICODE),
                    'headers' => json_encode($event->request->headers, JSON_UNESCAPED_UNICODE),
                    'method' => $event->request->method ?? '',
                    'time' => $event->request->requestTime ?? 0,
                    'url' => $event->request->host . $event->request->path,
                ],
                'response' => [
                    'body' => $event->response->body,
                    'http_code' => $event->response->httpCode,
                ],
                'created_time' => micro_timestamp(),
            ];

            // 使用協程進行非阻塞檔案寫入
            \Swoole\Coroutine::create(function () use ($logData) {
                $logPath = \BASE_PATH . '/runtime/logs/gf_request_vendor.log';
                $logDir = dirname($logPath);
                if (!is_dir($logDir)) {
                    mkdir($logDir, 0755, true);
                }
                $logContent = json_encode($logData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL;
                file_put_contents($logPath, $logContent, FILE_APPEND | LOCK_EX);
            });
        }
    }

}