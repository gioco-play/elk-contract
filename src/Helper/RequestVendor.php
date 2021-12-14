<?php

declare(strict_types=1);

namespace GiocoPlus\ELK\Helper;

use Psr\Http\Message\ResponseInterface;

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
    public $path;

    /**
     * @var string
     */
    public $method;

    /**
     * @var array
     */
    public $request;

    /**
     * @var array
     */
    public $requestHeaders;

    /**
     * @var float
     */
    public $requestTime;

    /**
     * @var int
     */
    public $responseHttpCode;

    /**
     * @var array
     */
    public $responseHeaders;

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

    /**
     * RequestVendor constructor.
     * @param string $opCode
     * @param string $vendorCode
     * @param string $host
     * @param string $path
     * @param string $method
     * @param array $request
     * @param float $requestTime
     * @param string $response
     * @param ResponseInterface $resp
     * @param array $requestHeaders
     */
    public function __construct(
        string $opCode,
        string $vendorCode,
        string $host,
        string $path,
        string $method,
        array $request,
        float $requestTime,
        string $response,
        ResponseInterface $resp,
        array $requestHeaders = []
    )
    {
        $this->opCode = $opCode;
        $this->vendorCode = $vendorCode;
        $this->host = $host;
        $this->path = $path;
        $this->method = $method;
        $this->request = $request;
        $this->requestHeaders = $requestHeaders;
        $this->requestTime = $requestTime;

        $this->response = $response;
        $this->responseHttpCode = $resp->getStatusCode();
        $this->responseHeaders = $resp->getHeaders();
    }
}