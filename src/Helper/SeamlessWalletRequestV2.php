<?php

namespace GiocoPlus\ELK\Helper;

class SeamlessWalletRequestV2
{
    /**
     * @var string
     */
    public $opCode;

    /**
     * @var string
     */
    public $host;

    /**
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    public $requestParams;

    /**
     * @var string
     */
    public $requestEncrypt;

    /**
     * @var array
     */
    public $requestHeaders;

    /**
     * @var string
     */
    public $response;

    /**
     * @var string
     */
    public $responseDecrypt;

    /**
     * @var float
     */
    public $requestTime;

    /**
     * @var string
     */
    public $respCode;

    public function __construct(string $opCode, string $host, string $path, array $requestParams, string $requestEncrypt, array $requestHeaders, string $response, string $responseDecrypt, $requestTime, $respCode) {
        $this->opCode = $opCode;
        $this->host = $host;
        $this->path = $path;
        $this->requestParams = $requestParams;
        $this->requestEncrypt = $requestEncrypt;
        $this->requestHeaders = $requestHeaders;
        $this->response = $response;
        $this->responseDecrypt = $responseDecrypt;
        $this->requestTime = $requestTime;
        $this->respCode = $respCode;
    }
}