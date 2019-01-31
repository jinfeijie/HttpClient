<?php
/**
 * Created by PhpStorm.
 * Project: HttpClient
 * User: jimcy
 * Date: 2019-01-31
 * Time: 21:44
 */

namespace HttpClient\TestHttpClient;


use HttpClient\AsyncClient;
use PHPUnit\Framework\TestCase;

class TestAsyncClient extends TestCase
{
    public function testAsyncGet()
    {
        $promise  = (new AsyncClient('https://jinfeijie.cn', 'GET'))
            ->setAuth(['jinfeijie','whoami'])
            ->send();

        $results = $promise->wait();
        $this->setResult($results);
        var_dump($this->getResult());
        $this->assertIsObject($results);
    }

    public function testAsyncGetWait()
    {
        $promise  = (new AsyncClient('https://jinfeijie.cn', 'GET'))
            ->setAuth(['jinfeijie','whoami'])
            ->send();

        $results = (string)$promise->wait()->getBody();
        $this->setResult($results);
        echo $this->getResult();
        $this->assertIsString($results);
    }
}