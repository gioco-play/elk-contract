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
     * @var float
     */
    public $requestTime;

    /**
     * @var array
     */
    public $header;

    public function __construct(
        string $host,
        string $path,
        string $method,
        float $requestTime,
        array $header = []
    ) {
        $this->host = $host;
        $this->path = $path;
        $this->method = $method;
        $this->requestTime = $requestTime;
        $this->header = $header;
    }
}