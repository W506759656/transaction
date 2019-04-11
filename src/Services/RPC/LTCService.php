<?php

namespace iBrand\EC\Open\Server\Services;

class LTCService extends BTCService
{
    public function __construct()
    {
        parent::__construct();

        $this->url = config('wallet.LTC.url');
        $this->auth = config('wallet.LTC.auth');
    }
}