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
    public $response;

    public function __construct(string $opCode, TransferStats $transferStats, array $requestParams, string $response) {
        $this->opCode = $opCode;
        $this->transferStats = $transferStats;
        $this->requestParams = $requestParams;
        $this->response = $response;
    }
}