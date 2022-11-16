<?php
declare(strict_types=1);
namespace GiocoPlus\ELK\Helper;

use GiocoPlus\ELK\Helper\RequestVendorStruct\RequestStruct;
use GiocoPlus\ELK\Helper\RequestVendorStruct\ResponseStruct;

class RequestVendorV2
{
    /**
     * @var string
     */
    public $opCode;

    /**
     * @var string
     */
    public $vendorCode;

    /**
     * @var RequestStruct
     */
    public $request;

    /**
     * @var ResponseStruct
     */
    public $response;

    public function __construct(
        string $opCode,
        string $vendorCode,
        RequestStruct $request,
        ResponseStruct $response
    )
    {
        $this->opCode = $opCode;
        $this->vendorCode = $vendorCode;
        $this->request = $request;
        $this->response = $response;
    }
}