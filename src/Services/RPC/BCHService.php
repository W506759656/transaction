<?php

namespace iBrand\EC\Open\Server\Services;

class BCHService extends BTCService
{
    public function __construct()
    {
        parent::__construct();

        $this->url = config('wallet.BCH.url');
        $this->auth = config('wallet.BCH.auth');
    }
}