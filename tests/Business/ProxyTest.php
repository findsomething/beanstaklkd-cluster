<?php
/**
 * Created by PhpStorm.
 * User: lihan
 * Date: 16/11/1
 * Time: 15:12
 */
namespace FSth\BeanstalkdCluster\Test\Business;

use FSth\BeanstalkdCluster\Business\Entry;
use FSth\BeanstalkdCluster\Business\Proxy;

class ProxyTest extends \PHPUnit_Framework_TestCase
{
    private $proxy;

    private $config;
    private $tags = array('tag1', 'tag2', 'tag3');
    private $ports = array(
        array('11300'),
        array('11300', '11301'),
        array('11302', '11303', '11304')
    );

    public function setUp()
    {
        $this->proxy = new Proxy();
        $this->initProxy();
    }

    public function testGet()
    {
        $key = 0;
        $tubeName = $this->config[$key]['tubeNames'][$key];
        $config = $this->proxy->lookup($tubeName);
        echo "{$tubeName} -> {$config['host']}:{$config['port']}\n";
        $this->assertTrue(in_array($config['port'], $this->ports[$key]));

        $key = 1;
        $tubeName = $this->config[$key]['tubeNames'][$key];
        $config = $this->proxy->lookup($tubeName);
        echo "{$tubeName} -> {$config['host']}:{$config['port']}\n";
        $this->assertTrue(in_array($config['port'], $this->ports[$key]));

        $key = 2;
        $tubeName = $this->config[$key]['tubeNames'][$key];
        $config = $this->proxy->lookup($tubeName);
        echo "{$tubeName} -> {$config['host']}:{$config['port']}\n";
        $this->assertTrue(in_array($config['port'], $this->ports[$key]));
    }

    private function initProxy()
    {
        $this->setConfig();
//        foreach ($this->config as $key => $config) {
//            $entry = new Entry($config['name'], $config['tubeNames'], $config['config']);
//            $this->proxy->setEntry($entry);
//        }
        $this->proxy->initWithConfig($this->config);
    }

    /*
     * array(
     *      array(
     *          'tubeNames' => array(),
     *          'hosts' => array('host' => '', 'port' => ''),
     *          'name' => ''
     *      )
     * )
     */
    private function setConfig()
    {
        $this->config[] = $this->getConfig($this->tags[0], 1, array('11300'));
        $this->config[] = $this->getConfig($this->tags[1], 2, array('11300', '11301'));
        $this->config[] = $this->getConfig($this->tags[2], 10, array('11302', '11303', '11304'));
    }

    private function getConfig($tag, $num, $ports)
    {
        $tubeNames = array();
        $hosts = array();
        for ($i = 1; $i <= $num; $i++) {
            $tubeNames[] = $this->getTubeName($tag, $i);
        }
        foreach ($ports as $port) {
            $hosts[] = array('host' => '127.0.0.1', 'port' => $port);
        }
        return array(
            'tubeNames' => $tubeNames,
            'hosts' => $hosts,
            'name' => $tag
        );
    }

    private function getTubeName($tag, $num)
    {
        return "testTube:{$tag}:{$num}";
    }
}