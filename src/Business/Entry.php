<?php
/**
 * Created by PhpStorm.
 * User: lihan
 * Date: 16/10/26
 * Time: 14:41
 */
namespace FSth\BeanstalkdCluster\Business;

use Flexihash\Flexihash;

class Entry
{
    private $name;
    private $tubeNames;
    private $configs;

    private $hash;

    public function __construct($name, array $tubeNames, array $configs)
    {
        $this->name = $name;
        $this->tubeNames = $tubeNames;
        $this->configs = $configs;
        $this->initHash();
    }

    public function initHash()
    {
        $this->hash = new Flexihash();
        foreach ($this->configs as $config) {
            $this->hash->addTarget($this->toKey($config['host'], $config['port']));
        }
    }

    public function contains($tubeName)
    {
        return in_array($tubeName, $this->tubeNames);
    }

    public function lookup($tubeName)
    {
        $key = $this->hash->lookup($tubeName);
        return $this->parseKey($key);
    }

    private function toKey($host, $port)
    {
        return "{$host}_{$port}";
    }

    private function parseKey($key)
    {
        $value = explode("_", $key);
        return array(
            'host' => $value[0],
            'port' => $value[1]
        );
    }
}