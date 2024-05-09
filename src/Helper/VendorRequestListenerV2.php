<?php
declare(strict_types=1);
namespace GiocoPlus\ELK\Helper;

use Hyperf\Event\Contract\ListenerInterface;
use Psr\Container\ContainerInterface;

class VendorRequestListenerV2 implements ListenerInterface
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
            VendorRequest::class
        ];
    }

    public function process(object $event)
    {
        $vendorCode = strtolower($event->vendorCode);
        $responseOther = $event->responseOther;
        $params = [
            'vendor_code' => $vendorCode,
            'path' => $event->requestPath,
            'request' => [
                'params' => $event->requestParams,
                'method' => $event->requestMethod,
                'headers' => $event->requestHeaders,
            ],
            'response' => [
                'body' => $event->response,
                'other' => $responseOther
            ],
            'execTime' => $execTime ?? 0,
            'created_time' => micro_timestamp(),
        ];

        $others = json_decode($responseOther, true);
        if (isset($others['operator_code'])) {
            $params['response']['operator_code'] = strtoupper($others['operator_code']);
        }

        $uri = '/vendorRequestGf/';
        $specifiedVendor = [
            "pg"
        ];
        if (in_array(strtolower($vendorCode), $specifiedVendor)) {
            $uri = "/vendorRequestGf/{$vendorCode}";
        }

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
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);
//        $info = curl_getinfo($ch);
        $err = curl_error($ch);
        curl_close($ch);

//        $httpCode = $info['http_code'] ?? 0;
//        $requestTime = floatval($info['total_time'] ?? 0);

        if ($err) {
            var_dump(__CLASS__ . " err: " . $err);
        }

        return json_decode($response, true);
    }
}