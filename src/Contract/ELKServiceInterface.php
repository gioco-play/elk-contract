<?php
declare(strict_types=1);
namespace GiocoPlus\ELK\Contract;
/**
 * ELK
 */
interface ELKServiceInterface {

    /**
     * GF 請求 vendor 的 log
     * @param string $vendorCode   遊戲商代碼
     * @param string $opCode       營運商代碼
     * @param string $host          請求 domain
     * @param string $path           請求路徑
     * @param string $method       請求方法
     * @param array $request        請求參數
     * @param float $requestTime   請求執行時間
     * @param string $response      vendor response 返回內容
     * @param int $responseHttpCode        response http code
     * @param array $responseHeaders         response header
     * @param array $requestHeaders 可選 請求 headers
     *
     * @return mixed
     */
    function gfRequestVendor(
        string $vendorCode,
        string $opCode,
        string $host,
        string $path,
        string $method,
        array $request,
        float $requestTime,
        string $response,
        int $responseHttpCode,
        array $responseHeaders,
        array $requestHeaders
    );

    /**
     * vendor 請求 GF 的 log
     * @param string $vendorCode
     * @param string $path 請求路徑
     * @param string $requestParams
     * @param string $requestMethod
     * @param string $requestHeaders
     * @param int $execTime 執行時間 second
     * @param string $response
     * @param string $responseOther
     * @return mixed
     */
    function vendorRequestGF(string $vendorCode, string $path, string $requestParams, string $requestMethod, string $requestHeaders, int $execTime, string $response, string $responseOther = '');

    /**
     * @param string $op_code 營運商代碼
     * @param string $host
     * @param string $path
     * @param array $requestParams
     * @param float $transferTime 請求時間
     * @param array $response 返回 ["body" , "headers" , "status_code"]
     * @return mixed
     */
    function seamlessWalletRequest(string $op_code, string $host, string $path, array $requestParams, float $transferTime, array $response);

    /**
     * 提交資料至ELK
     *
     * @param string $uri
     * @param array $data
     * @return mixed
     */
    function post(string $uri, array $data);
}

