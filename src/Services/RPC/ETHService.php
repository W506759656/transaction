<?php

namespace Wding\Transcatin\Services;


use Exception;
use GuzzleHttp\Client;

/**
 * Class ETHService
 * @package App\Services\RPC
 *
 * @method string eth_blockNumber()
 * @method array eth_getBlockByNumber(string $blockNumber, bool $returnFulltranscation)
 * @method array eth_getLogs(array $options)
 * @method string personal_newAccount(string $password)
 * @method string personal_sendtranscation(array $transcation, string $password)
 */
class ETHService
{
    protected $http;

    protected $url;

    public function __construct()
    {
        $this->http = new Client();
        $this->url = config('wallet.ETH.url');
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
            'json' => [
                'id' => 1,
                'jsonrpc' => '2.0',
                'method' => $method,
                'params' => $params,
            ],
        ]);
        $content = json_decode($response->getBody()->getContents(), true);
        if (array_key_exists('error', $content) && $content['error'] !== null) {
            $error = json_encode($content['error']);
            throw new Exception($error);
        }
        $result = $content['result'];
        if ($result === null) {
            throw new Exception('Result is null');
        }
        return $result;
    }
}