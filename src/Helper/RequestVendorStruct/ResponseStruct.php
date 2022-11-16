<?php

namespace GiocoPlus\ELK\Helper\RequestVendorStruct;

class ResponseStruct
{
    /**
     * @var string
     */
    public $body;

    /**
     * @var int
     */
    public $httpCode;

    public function __construct(
        string $body,
        int $httpCode
    )
    {
        $this->body = $body;
        $this->httpCode = $httpCode;

        return $this;
    }
}