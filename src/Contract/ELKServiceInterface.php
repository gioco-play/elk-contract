<?php
declare(strict_types=1);
namespace GiocoPlus\ELK\Contract;
/**
 * ELK
 */
interface ELKServiceInterface {

    /**
     * GF 請求 vendor 的 log
     * @param string $vendor_code   // 遊戲商代碼
     * @param string $op_code       // 營運商代碼
     * @param string $host          // 請求url
     * @param string $url           // 請求url function
     * @param array $request        // 請求參數
     * @param float $request_time   // 請求執行時間
     * @param int $http_code        // http code
     * @param array $header         // response header
     * @param string $response      // vendor response
     * @return mixed
     */
    function gfRequestVendor(string $vendor_code,
                             string $op_code,
                             string $host,
                             string $url,
                             array $request,
                             float $request_time,
                             int $http_code,
                             array $header,
                             string $response
    );

    /**
     * vendor 請求 GF 的 log
     * @param string $vendor_code 遊戲商代碼
     * @param string $path 請求路徑
     * @param array $request 請求 ["method" 方法, "data" 資料, "header" 標頭    ]
     * @param array $response 返回 ["data" 資料, "http_code" HTTP狀態碼 ]
     * @param int $execTime 執行時間 second
     * @param int $createTime 13 digit timestamp
     * @return mixed
     */
    function vendorRequestGF(string $vendor_code, string $path, array $request, array $response, int $execTime, int $createTime);

    /**
     * 提交資料至ELK
     *
     * @param string $uri
     * @param array $data
     * @return mixed
     */
    function post(string $uri, array $data);
}

