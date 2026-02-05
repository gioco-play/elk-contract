<?php

declare(strict_types=1);
namespace GiocoPlus\ELK\Helper;

use Hyperf\HttpServer\Contract\RequestInterface;

class VendorRequestLocal
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
     * @var string|null
     */
    public $operatorCode;

    /**
     * VendorRequest constructor.
     * @param RequestInterface $request
     * @param string $vendorCode
     * @param string $response
     * @param int|null $execStart 選填，執行起始時間，預設為當前時間
     * @param string|null $operatorCode 選填，營運商代碼
     * @param string $responseOther 選填，json_encode 後的字串
     */
    public function __construct(RequestInterface $request, string $vendorCode, string $response, ?int $execStart = null, ?string $operatorCode = null, string $responseOther = '')
    {
        $this->vendorCode = $vendorCode;
        $this->requestPath = $request->path();
        
        $requestParams = $request->all();
        if (empty($requestParams)) {
            $requestParams = ['body' => (string) $request->getBody()];
        }

        $decryptRequest = $request->getAttribute('decrypt_request');
        if ($decryptRequest) {
            $requestParams['decrypt_request'] = $decryptRequest;
        }

        $this->requestParams = $requestParams;
        $this->requestMethod = $request->getMethod();
        $this->requestHeaders = $request->getHeaders();
        $this->execStart = $execStart ?? micro_timestamp();
        $this->response = $response;
        $this->responseOther = $responseOther;
        $this->operatorCode = $operatorCode;
    }
}