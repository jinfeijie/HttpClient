<?php
/**
 * Created by PhpStorm.
 * Project: HttpClient
 * User: jimcy
 * Date: 2019-01-31
 * Time: 21:03
 */

namespace HttpClient;


interface HttpClientInterface
{

    /**
     * 设置主域
     *
     * @param string $uri
     *
     * @return mixed
     */
    public function setBaseUri(string $uri);

    public function getOptions();

    /**
     * 设置请求头
     *
     * @param array $header
     *
     * @return $this
     */
    public function setHeader(array $header);
    public function getHeader();

    /**
     * 设置认证
     *
     * @param array $auth
     *
     * @return $this
     */
    public function setAuth(array $auth);
    public function getAuth();

    /**
     * 设置表单请求
     *
     * @param array $formParams
     *
     * @return $this
     */
    public function setFormParams(array $formParams);
    public function getFormParams();

    /**
     * 超时时间
     *
     * @param float $second
     *
     * @return BaseClient
     */
    public function setTimeOut($second);
    public function getTimeOut();

    /**
     * 设置参数
     *
     * @param array  $params  默认是string  || 传入 array     || 任意内容
     * @param string $options 默认是空      ||     json       || stream
     *
     * @return BaseClient
     */
    public function setParams($params, $options = '');
    public function getParams();

    /**
     * 设置请求参数
     *
     * @param array $query
     *
     * @return $this
     */
    public function setQuery(array $query);
    public function getQuery();

    /**
     * 是否允许跳转
     *
     * @param bool $allow
     *
     * @return BaseClient
     */
    public function setAllowRedirects(bool $allow = false);
    public function getAllowRedirects();

    /**
     * 设置cookies
     *
     * @param array $cookies
     *
     * @return $this
     */
    public function setCookies(array $cookies);
    public function getCookies();

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
     * @return BaseClient
     */
    public function setContentType($type, $force = false);
}