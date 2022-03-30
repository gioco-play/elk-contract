<?php
declare(strict_types=1);

namespace GiocoPlus\ELK\Helper;

use GuzzleHttp\TransferStats;

class SeamlessWalletRequest
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
     * @var TransferStats
     */
    public $transferStats;

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

    public function __construct(string $opCode, string $host, string $path, TransferStats $transferStats, array $requestParams, string $requestEncrypt, array $requestHeaders, string $response, string $responseDecrypt) {
        $this->opCode = $opCode;
        $this->host = $host;
        $this->path = $path;
        $this->transferStats = $transferStats;
        $this->requestParams = $requestParams;
        $this->requestEncrypt = $requestEncrypt;
        $this->requestHeaders = $requestHeaders;
        $this->response = $response;
        $this->responseDecrypt = $responseDecrypt;
    }



}