<?php

declare(strict_types=1);
namespace GiocoPlus\ELK\Helper;

use Psr\Container\ContainerInterface;
use Hyperf\Event\Contract\ListenerInterface;

class LineNotifyListener implements ListenerInterface {
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var bool Line 通知啟用狀態
     */
    private $notifyEnabled = false;

    /**
     * @var string
     */
    private $notifyAccessToken;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function listen(): array
    {
        return [
            LineNotify::class
        ];
    }

    public function process(object $event)
    {
        if (empty($event->notifyAccessToken)) {
            throw new \Exception('lint notify, token is not configured successfully');
        }
        $this->notifyAccessToken = $event->notifyAccessToken;

        $envTxt = env('SERVICE_ENV', 'unknown');
        $sendMsg = "[{$envTxt}]" . "\r\n";
        if (! empty($event->vendorCode)) {
            $sendMsg .= "遊戲商：{$event->vendorCode}" . "\r\n";
        }
        if (! empty($event->opCode)) {
            $sendMsg .= "營商代碼：{$event->opCode}" . "\r\n";
        }
        $sendMsg .= "\r\n" . $event->message;

        co(function () use ($sendMsg) {
            $this->curlPost($sendMsg);
        });
    }

    private function curlPost(string $message)
    {
        $url = 'https://notify-api.line.me/api/notify';

        $curl = curl_init();
        $headers = array(
            "Content-Type: application/x-www-form-urlencoded",
            "Authorization: Bearer {$this->notifyAccessToken}",
        );
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => http_build_query(['message' => $message]),
            CURLOPT_HTTPHEADER => $headers,
        ));

        $response = curl_exec($curl);
        var_dump("line notify, resp:". json_encode($response));
        curl_close($curl);
    }
}

