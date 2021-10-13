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
    public $requestData;

    /**
     * @var string
     */
    public $requestMethod;

    /**
     * @var array
     */
    public $requestHeaders;

    /**
     * @var array
     */
    public $responseArr;

    /**
     * @var int
     */
    public $execStart;

    public function __construct(RequestInterface $request, string $vendorCode, array $responseArr, int $execStart)
    {
        $this->vendorCode = $vendorCode;
        $this->requestPath = $request->path();
        $this->requestData = $request->all();
        $this->requestMethod = $request->getMethod();
        $this->requestHeaders = $request->getHeaders();
        $this->responseArr = $responseArr;
        $this->execStart = $execStart;
    }
}