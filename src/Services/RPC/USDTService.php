<?php

namespace iBrand\EC\Open\Server\Services;

/**
 * Class USDTService
 * @package App\Services
 *
 * @method array omni_listtransactions(string $account, int $count)
 * @method string omni_funded_send(string $fromAddress, string $toAddress, int $id, $number, string $feeAddress)
 */
class USDTService extends BTCService
{
    public function __construct()
    {
        parent::__construct();

        $this->url = config('wallet.USDT.url');
        $this->auth = config('wallet.USDT.auth');
    }
}