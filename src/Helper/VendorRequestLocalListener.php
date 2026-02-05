<?php
declare(strict_types=1);
namespace GiocoPlus\ELK\Helper;

use Hyperf\Event\Contract\ListenerInterface;
use Psr\Container\ContainerInterface;

class VendorRequestLocalListener implements ListenerInterface
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
            VendorRequestLocal::class
        ];
    }

    public function process(object $event)
    {
        if (!$event instanceof VendorRequestLocal) {
            return;
        }

        $vendorCode = strtolower($event->vendorCode);
        $responseOther = $event->responseOther;
        $execStart = $event->execStart;
        
        // 確保 timestamp 為 13 位毫秒級（右側補 0）
        // 例：10 位秒級 1707122418 → "1707122418000" → 1707122418000
        $execStart = intval(str_pad(strval($execStart), 13, '0', STR_PAD_RIGHT));

        $params = [
            'vendor_code' => $vendorCode,
            'path' => $event->requestPath,
            'request' => [
                'params' => json_encode($event->requestParams, JSON_UNESCAPED_UNICODE),
                'method' => $event->requestMethod,
                'headers' => json_encode($event->requestHeaders, JSON_UNESCAPED_UNICODE),
            ],
            'response' => [
                'body' => $event->response,
                'other' => $responseOther
            ],
            'execTime' => (micro_timestamp() - $execStart) / 1000,
            'created_time' => micro_timestamp(),
        ];

        if (!empty($event->operatorCode)) {
            $params['operator_code'] = strtoupper($event->operatorCode);
        }

        // 使用協程進行非阻塞檔案寫入
        \Swoole\Coroutine::create(function () use ($params) {
            $date = (new \DateTime('now', new \DateTimeZone('Asia/Taipei')))->format('Y-m-d');
            $logPath = \BASE_PATH . '/runtime/logs/vendor_request_gf_' . $date . '.log';
            $logDir = dirname($logPath);
            if (!is_dir($logDir)) {
                mkdir($logDir, 0755, true);
            }
            $logContent = json_encode($params, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL;
            file_put_contents($logPath, $logContent, FILE_APPEND | LOCK_EX);
        });
    }
}