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
        string $body = '',
        int $httpCode = 0
    )
    {
        $this->body = $body;
        $this->httpCode = $httpCode;

        return $this;
    }

    public static function toObject(array $data): ResponseStruct
    {
        $array = new ResponseStruct();
        foreach ($data as $k => $v) {
            $array->$k = $v;
        }

        return $array;
    }
}