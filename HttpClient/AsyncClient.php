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

    public function __construct($base_uri = '', $method = 'POST')
    {
        $this->base_uri = $base_uri;
        $this->method = $method;
        parent::__construct($this->base_uri, $this->method, $this->type);
    }
    /**
     * 获取连接的客户端
     * @param string $base_uri
     * @param string $method
     *
     * @return AsyncClient
     */
    public function getClient($base_uri = '', $method = 'POST')
    {
        $this->base_uri = $base_uri;
        $this->method = $method;
        if (!empty($this->base_uri)) {
            $this->setBaseUri($this->base_uri);
        }
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

    /**
     * 获取内容
     * @param string $uri
     * @param bool   $format
     * @param bool   $base64
     *
     * @return bool|mixed|string
     */
    public function getContent($uri = '/', $format = false, $base64 = false)
    {
        $this->uri = $uri;
        $this->type = empty($this->type) ? '' : 'Async';
        $return = '';
        switch (strtolower($this->method)) {
            case 'get' :
            case 'post' :
            case 'head':
            case 'put':
            case 'patch':
            case 'delete' :
                $method = strtolower($this->method) . $this->type;
                try {
                    $return = $this->client->$method($this->uri, $this->options)->wait();
                } catch (\Exception $e) {
                    Log::error(__METHOD__, [
                        'line' => $e->getLine(),
                        'msg'  => $e->getMessage(),
                        'code' => $e->getCode(),
                    ]);
                    return $return;
                }

                break;
            default:
                return false;
        }
        $body = (string)$return->getBody();
        $contentType = $return->getHeaderLine('content-type');
        if ($format) {
            return $this->formatContent($body, $contentType, $base64);
        }
        return $body;
    }

    /**
     * 格式化返回的数据
     *
     * @param      $body
     * @param      $contentType
     * @param bool $base64
     *
     * @return mixed|string
     */
    protected function formatContent($body, $contentType, $base64 = false)
    {
        $type = explode(";", $contentType)[0];
        if (empty($type)) {
            $type = $this->contentType;
        }

        if ($this->forceContentType) {
            $type = $this->contentType;
        }


        switch ($type) {
            case 'image/jpeg':
            case 'image/png':
            case 'text/html':
                if ($base64) {
                    return base64_encode($body);
                }
                return $body;
                break;
            case 'application/json':
                if ($base64) {
                    return base64_encode($body);
                }
                $ret = json_decode($body, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    return $body;
                }
                return $ret;
                break;
            default:
                if ($base64) {
                    return base64_encode($body);
                }
                return $body;
        }
    }
}