<?php
/**
 * Created by PhpStorm.
 * Project: HttpClient
 * User: jimcy
 * Date: 2019-01-31
 * Time: 20:53
 */

namespace HttpClient;

use GuzzleHttp\Promise\Promise;
use Illuminate\Support\Facades\Log;

class AsyncClient extends BaseClient
{
    protected $base_uri;
    protected $uri = '/';
    protected $method = 'POST';
    protected $client = null;
    protected $type = 'Async';
    protected $options = [];
    protected $contentType = 'text/html';
    protected $forceContentType = '';


    public function __construct($base_uri, $method = 'POST')
    {
        $this->base_uri = $base_uri;
        $this->method = $method;
        parent::__construct($this->base_uri, $this->method, $this->type);
        return $this;
    }

    /**
     * 发送请求
     *
     * @param string $uri
     *
     * @return bool | Promise
     */
    public function send($uri = '/')
    {
        $this->uri = $uri;
        $this->type = empty($this->type) ? '' : 'Async';
        switch (strtolower($this->method)) {
            case 'get' :
            case 'post' :
            case 'head':
            case 'put':
            case 'patch':
            case 'delete' :
                $method = strtolower($this->method) . $this->type;
                try {
                    return $this->client->$method($this->uri, $this->options);
                } catch (\Exception $e) {
                    Log::error(__METHOD__, [
                        'line' => $e->getLine(),
                        'msg'  => $e->getMessage(),
                        'code' => $e->getCode(),
                    ]);
                    return false;
                }

                break;
            default:
                return false;
        }
    }

    public function getContent($uri = '/')
    {
        $this->uri = $uri;
        $this->type = empty($this->type) ? '' : 'Async';
        switch (strtolower($this->method)) {
            case 'get' :
            case 'post' :
            case 'head':
            case 'put':
            case 'patch':
            case 'delete' :
                $method = strtolower($this->method) . $this->type;
                try {
                    return (string)$this->client->$method($this->uri, $this->options)->wait()->getBody();
                } catch (\Exception $e) {
                    Log::error(__METHOD__, [
                        'line' => $e->getLine(),
                        'msg'  => $e->getMessage(),
                        'code' => $e->getCode(),
                    ]);
                    return false;
                }

                break;
            default:
                return false;
        }
    }
}