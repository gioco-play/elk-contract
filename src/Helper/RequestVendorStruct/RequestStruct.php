<?php

namespace GiocoPlus\ELK\Helper\RequestVendorStruct;

class RequestStruct
{
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
    public $params;

    /**
     * @var float
     */
    public $requestTime;

    /**
     * @var array
     */
    public $headers;

    public function __construct(
        string $host,
        string $path,
        string $method,
        array $params,
        float $requestTime,
        array $headers = []
    ) {
        $this->host = $host;
        $this->path = $path;
        $this->method = $method;
        $this->params = $params;
        $this->requestTime = $requestTime;
        $this->headers = $headers;

        return $this;
    }
}