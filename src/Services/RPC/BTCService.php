<?php

namespace iBrand\EC\Open\Server\Services;

use Exception;
use GuzzleHttp\Client;

/**
 * Class BTCService
 * @package App\Services
 *
 * @method string getnewaddress(string $account)
 * @method string sendtoaddress(string $address, string $number)
 * @method array listtransactions(string $account, int $count)
 */
class BTCService
{
    protected $http;

    protected $url;
    protected $auth;

    public function __construct()
    {
        $this->http = new Client();
        $this->url = config('wallet.BTC.url');
        $this->auth = config('wallet.BTC.auth');
    }

    /**
     * @param $method
     * @param $params
     * @return mixed
     * @throws Exception
     */
    public function __call($method, $params)
    {
        $response = $this->http->post($this->url, [
            'auth' => $this->auth,
            'json' => [
                'id' => 1,
                'jsonrpc' => '1.0',
                'method' => $method,
                'params' => $params,
            ],
        ]);
        $content = json_decode($response->getBody()->getContents(), true);
        if (array_key_exists('error', $content) && $content['error'] !== null) {
            $error = json_encode($content['error']);
            throw new Exception('RPC ERROR: ' . $error);
        }

        return $content['result'];
    }
}
