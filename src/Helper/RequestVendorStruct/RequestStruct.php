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
        string $host = '',
        string $path = '',
        string $method = '',
        array $params = [],
        float $requestTime = 0,
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

    public static function toObject(array $data): RequestStruct
    {
        $array = new RequestStruct();
        foreach ($data as $k => $v) {
            $array->$k = $v;
        }

        return $array;
    }
}