<?php
/**
 * Created by PhpStorm.
 * Project: HttpClient
 * User: jimcy
 * Date: 2019-01-31
 * Time: 21:16
 */

namespace HttpClient\TestHttpClient;

use HttpClient\HttpClient;
use PHPUnit\Framework\TestCase;


class TestHttpClient extends TestCase
{
    public function testGet()
    {
        $string  = (new HttpClient())
            ->getClient('https://jinfeijie.cn', 'GET')
            ->setAuth(['jinfeijie','whoami'])
            ->send();

        $this->setResult($string);
        echo $this->getResult();
        $this->assertIsString($string);
    }

    public function testGetJsonString()
    {
        $string  = (new HttpClient())
            ->getClient('https://jinfeijie.cn/', 'GET')
            ->setAuth(['jinfeijie','whoami'])
            ->send('weixin/a.php');

        $this->setResult($string);
        echo $this->getResult();
        $this->assertIsString($string);
    }
    public function testGetJsonFormat()
    {
        $string  = (new HttpClient())
            ->getClient('https://jinfeijie.cn/', 'GET')
            ->setAuth(['jinfeijie','whoami'])
            ->send('weixin/a.php', true);

        $this->setResult($string);
        var_dump($this->getResult());
        $this->assertIsString($string);
    }
}