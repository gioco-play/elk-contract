<?php
declare(strict_types=1);
namespace GiocoPlus\ELK\Contract;
/**
 * ELK
 */
interface ELKServiceInterface {

    /**
     * 提交資料至ELK
     *
     * @param string $uri
     * @param array $data
     * @return array
     */
    function post(string $uri, array $data): array;
}

