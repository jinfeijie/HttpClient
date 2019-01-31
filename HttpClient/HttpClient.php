<?php
/**
 * Created by PhpStorm.
 * Project: HttpClient
 * User: jimcy
 * Date: 2019-01-31
 * Time: 20:52
 */

namespace HttpClient;

use Illuminate\Support\Facades\Log;
use Symfony\Contracts\Service\ResetInterface;

class HttpClient extends BaseClient
{
    protected $base_uri;
    protected $uri = '/';
    protected $method = 'POST';
    protected $client = null;
    protected $type = '';
    protected $options = [];
    protected $contentType = 'text/html';
    protected $forceContentType = '';


    public function __construct($base_uri, $method = 'POST')
    {
        $this->base_uri = $base_uri;
        $this->method = $method;
        parent::__construct($this->base_uri, $this->method, $this->type);
    }
    
    /**
     * 同步请求
     *
     * @param        $base_uri
     *
     *                                    主域名，比如请求 https://baidu.com/sb 这里只需要输入 https://baidu.com/
     *                                    具体参考 https://i.loli.net/2019/01/30/5c51963f4143e.png 或
     *                                    https://ws3.sinaimg.cn/large/005BYqpggy1fzovncewm8j31c80je0uk.jpg
     * @param string $method
     *
     * @return HttpClient
     */
    public function getClient($base_uri, $method = 'POST')
    {

    }

    /**
     * 发送请求
     *
     * @param string $uri
     *
     * @param bool   $format     是否格式化
     * @param bool   $base64     是否base64，比较适用于图片的数据流转码
     *
     * @return ResetInterface
     */
    public function send($uri = '/', $format = false, $base64 = false)
    {
        $this->uri = $uri;
        $this->type = $this->type ?? '';
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
                    $return = $this->client->$method($this->uri, $this->options);
                    if ($this->type == 'Async') {
                        return $return;
                    }
                }catch (\Exception $e) {
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