<?php
declare(strict_types=1);
namespace GiocoPlus\ELK\Helper;

class LineNotify
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
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $notifyAccessToken;

    public function __construct(string $token, string $message, array $options = [])
    {
        $this->notifyAccessToken = $token;
        $this->message = $message;

        if (isset($options['op_code'])) {
            $this->opCode = $options['op_code'];
        }

        if (isset($options['vendor_code'])) {
            $this->vendorCode = $options['vendor_code'];
        }
    }
}