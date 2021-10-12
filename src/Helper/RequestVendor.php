<?php

declare(strict_types=1);

namespace GiocoPlus\ELK\Helper;

/**
 * Class RequestVendor
 * @package App\Event
 */
class RequestVendor
{
    # 我方 請求 vendor

    /**
     * @var string
     */
    public $host;

    /**
     * @var string
     */
    public $url;

    /**
     * @var array
     */
    public $request;

    /**
     * @var float
     */
    public $requestTime;

    /**
     * @var int
     */
    public $httpCode;

    /**
     * @var array
     */
    public $header;

    /**
     * @var string
     */
    public $response;

    /**
     * @var string
     */
    public $opCode;

    /**
     * @var string
     */
    public $vendorCode;

    public function __construct(
        string $opCode,
        string $vendorCode,
        string $host,
        string $url,
        array $request,
        float $requestTime,
        int $httpCode,
        array $header,
        string $response
    ) {
        $this->opCode = $opCode;
        $this->vendorCode = $vendorCode;
        $this->host = $host;
        $this->url = $url;
        $this->request = $request;
        $this->requestTime = $requestTime;
        $this->httpCode = $httpCode;
        $this->header = $header;
        $this->response = $response;
    }
}