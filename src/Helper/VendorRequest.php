<?php

declare(strict_types=1);
namespace GiocoPlus\ELK\Helper;

use Hyperf\HttpServer\Contract\RequestInterface;

class VendorRequest
{
    /**
     * @var string
     */
    public $vendorCode;

    /**
     * @var string
     */
    public $requestPath;

    /**
     * @var array
     */
    public $requestParams;

    /**
     * @var string
     */
    public $requestMethod;

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
    public $responseOther;

    /**
     * @var int
     */
    public $execStart;

    /**
     * VendorRequest constructor.
     * @param RequestInterface $request
     * @param string $vendorCode
     * @param int $execStart
     * @param string $response
     * @param string $responseOther
     */
    public function __construct(RequestInterface $request, string $vendorCode, int $execStart, string $response, string $responseOther = '')
    {
        $this->vendorCode = $vendorCode;
        $this->requestPath = $request->path();
        $this->requestParams = $request->all();
        $this->requestMethod = $request->getMethod();
        $this->requestHeaders = $request->getHeaders();
        $this->execStart = $execStart;
        $this->response = $response;
        $this->responseOther = $responseOther;
    }
}