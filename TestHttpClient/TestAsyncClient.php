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
        $promise = (new AsyncClient())
            ->getClient('https://jinfeijie.cn', 'GET')
            ->setAuth(['jinfeijie', 'whoami'])
            ->send();

        $results = $promise->wait();
        $this->setResult($results);
        var_dump($this->getResult());
        $this->assertIsObject($results);
    }

    public function testAsyncGetWait()
    {
        $promise = (new AsyncClient())
            ->getClient('https://jinfeijie.cn', 'GET')
            ->setAuth(['jinfeijie', 'whoami'])
            ->send();

        $results = (string)$promise->wait()->getBody();
        $this->setResult($results);
        echo $this->getResult();
        $this->assertIsString($results);
    }

    public function testAsyncPost()
    {
        $promise = (new AsyncClient())
            ->getClient('https://jinfeijie.cn', 'POST')
            ->setAuth(['jinfeijie', 'whoami'])
            ->send();

        $results = $promise->wait();
        $this->setResult($results);
        var_dump($this->getResult());
        $this->assertIsObject($results);
    }

    public function testAsyncPostWait()
    {
        $promise = (new AsyncClient())
            ->getClient('https://jinfeijie.cn', 'POST')
            ->setAuth(['jinfeijie', 'whoami'])
            ->send();

        $results = (string)$promise->wait()->getBody();
        $this->setResult($results);
        echo $this->getResult();
        $this->assertIsString($results);
    }

    public function testAsyncJson()
    {
        $results = (new AsyncClient())
            ->getClient('https://jinfeijie.cn', 'GET')
            ->setAuth(['jinfeijie', 'whoami'])
            ->setContentType('application/json', true)
            ->getContent('weixin/a.php', true);

        $this->setResult($results);
        var_dump($this->getResult());
        $this->assertNotNull($results);
    }
}