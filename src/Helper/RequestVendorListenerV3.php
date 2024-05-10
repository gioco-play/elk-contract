<?php
declare(strict_types=1);
namespace GiocoPlus\ELK\Helper;

use Hyperf\Event\Contract\ListenerInterface;
use Psr\Container\ContainerInterface;
use GiocoPlus\ELK\Contract\ELKServiceInterface;
use GiocoPlus\ELK\Helper\RequestVendorStruct\RequestStruct;
use GiocoPlus\ELK\Helper\RequestVendorStruct\ResponseStruct;

class RequestVendorListenerV3 implements ListenerInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var ELKServiceInterface
     */
    private $elk;

    public function listen(): array
    {
        return [
            RequestVendorV2::class,
        ];
    }

    public function process(object $event)
    {
//        $request = RequestStruct::toObject($event->request);
//        $response = ResponseStruct::toObject($event->response);

        $request = $event->request;
        $response = $event->response;

        $params = [
            'vendor_code' => strtolower($event->vendorCode),
            'operator_code' => strtoupper($event->opCode),
            'host' => $request->host,
            'path' => $request->path,
            'request' => [
                'params' => json_encode($request->params, JSON_UNESCAPED_UNICODE),
                'headers' => json_encode($request->headers, JSON_UNESCAPED_UNICODE),
                'method' => $request->method ?? '',
                'time' => $request->requestTime ?? 0,
                'url' => $request->host . $request->path,
            ],
            'response' => [
                'body' => $response->body,
                'http_code' => $response->httpCode,
            ],
            'created_time' => intval(round(microtime(true) * 1000)),
        ];

        $uri = '/gfRequestVendor';
        co(function() use ($uri, $params) {
            $this->curlELK($uri, $params);
        });
    }

    private function curlELK(string $uri, array $data)
    {
        $requestUrl = env('ELK_HOST') . $uri;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $requestUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);
        $err = curl_error($ch);
        curl_close($ch);

        $httpCode = $info['http_code'] ?? 0;
        $requestTime = floatval($info['total_time'] ?? 0);

        var_dump(__CLASS__ . " httpCode: " . $httpCode . " requestTime: " . $requestTime);

        if ($err) {
            var_dump(__CLASS__ . " err: " . $err);
        }
        var_dump(__CLASS__ . " response: " . $response);

        if ($response) {
            return json_decode($response , true);
        }
        return $response;
    }
}