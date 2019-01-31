<?php
/**
 * Created by PhpStorm.
 * Project: HttpClient
 * User: jimcy
 * Date: 2019-01-31
 * Time: 21:00
 */

namespace HttpClient;


use GuzzleHttp\Cookie\CookieJar;
use function GuzzleHttp\Psr7\stream_for;
use GuzzleHttp\Client;

class BaseClient implements HttpClientInterface
{
    protected $base_uri;
    protected $uri = '/';
    protected $method = 'POST';
    protected $client = null;
    protected $type = '';
    protected $options = [];
    protected $contentType = 'text/html';
    protected $forceContentType = '';

    public function __construct($base_uri, $method, $type)
    {
        $this->base_uri = $base_uri;
        $this->method = $method;
        if (!empty($this->base_uri)) {
            $this->setBaseUri($this->base_uri);
        }
        $this->type = $type;
        return $this;
    }

    public function getOptions()
    {
        return $this->options;
    }

    /**
     * 设置请求头
     *
     * @param array $header
     *
     * @return $this
     */
    public function setHeader(array $header)
    {
        $this->options['headers'] = $header;
        return $this;
    }

    public function getHeader()
    {
        return $this->options['headers'];
    }

    /**
     * 设置认证
     *
     * @param array $auth
     *
     * @return $this
     */
    public function setAuth(array $auth)
    {
        $this->options['auth'] = $auth;
        return $this;
    }

    public function getAuth()
    {
        return $this->options['auth'];
    }

    /**
     * 设置表单请求
     *
     * @param array $formParams
     *
     * @return $this
     */
    public function setFormParams(array $formParams)
    {
        $this->options['form_params'] = $formParams;
        return $this;
    }

    public function getFormParams()
    {
        return $this->options['form_params'];
    }

    /**
     * 超时时间
     *
     * @param float $second
     *
     * @return $this
     */
    public function setTimeOut($second)
    {
        $this->options['timeout'] = (float)$second;
        return $this;
    }

    public function getTimeOut()
    {
        return $this->options['timeout'];
    }

    /**
     * 设置参数
     *
     * @param array  $params  默认是string  || 传入 array     || 任意内容
     * @param string $options 默认是空      ||     json       || stream
     *
     * @return $this
     */
    public function setParams($params, $options = '')
    {
        switch (strtolower($options)) {
            case 'json':
                $this->options['body'] = json_encode($params);
                break;
            case 'stream':
                $this->options['body'] = stream_for($params);
                break;
            default:
                $this->options['body'] = $params;
                break;
        }
        return $this;
    }

    public function getParams()
    {
        return $this->options['body'];
    }

    /**
     * 设置请求参数
     *
     * @param array $query
     *
     * @return $this
     */
    public function setQuery(array $query)
    {
        $this->options['query'] = $query;
        return $this;
    }

    public function getQuery()
    {
        return $this->options['query'];
    }

    /**
     * 是否允许跳转
     *
     * @param bool $allow
     *
     * @return $this
     */
    public function setAllowRedirects(bool $allow = false)
    {
        $this->options['allow_redirects'] = $allow;
        return $this;
    }

    public function getAllowRedirects()
    {
        return $this->options['allow_redirects'];
    }

    /**
     * 设置cookies
     *
     * @param array $cookies
     *
     * @return $this
     */
    public function setCookies(array $cookies)
    {
        $cookie = CookieJar::fromArray($cookies, $this->base_uri);
        $this->options['cookies'] = $cookie;
        return $this;
    }

    public function getCookies()
    {
        return $this->options['cookies'];
    }


    /**
     * 设置返回内容的类型
     *
     * @param      $type
     *                    text/html
     *                    image/jpeg
     *                    image/png
     *                    application/json
     *
     * @param bool $force 强制，返回时无类型的内容转码失败时的兜底
     *
     * @return $this
     */
    public function setContentType($type, $force = false)
    {
        $this->contentType = (string)$type;
        $this->forceContentType = $force;
        return $this;
    }

    /**
     * 设置主域
     *
     * @param string $uri
     *
     * @return $this
     */
    public function setBaseUri(string $uri)
    {
        if ($this->client === null) {
            $this->base_uri = $uri;
            $this->client = new Client(['base_uri' => $this->base_uri]);
        }
        return $this;
    }
}