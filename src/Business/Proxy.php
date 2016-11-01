<?php
/**
 * Created by PhpStorm.
 * User: lihan
 * Date: 16/10/26
 * Time: 14:56
 */
namespace FSth\BeanstalkdCluster\Business;

use Fsth\BeanstalkdCluster\Exception\BeanstalkdExcetpion;
use FSth\BeanstalkdCluster\Tool\ArrayTool;

class Proxy
{
    private $entries;

    public function __construct()
    {
    }

    /**
     * @param array $configs
     * array(
     *  array(
     *      'name' => xxx,
     *      'tubeNames' => array('', '', ...),
     *      'hosts' => array(
     *          array('host' => xxx, 'port' => xxx),
     *          ...
     *      )
     *  ),
     *  ...
     * )
     */
    public function initWithConfig(array $configs)
    {
        $this->checkConfigs($configs);
        foreach ($configs as $config) {
            $entry = new Entry($config['name'], $config['tubeNames'], $config['hosts']);
            $this->setEntry($entry);
        }
    }

    public function setEntries(array $entries)
    {
        $this->entries = $entries;
    }

    public function setEntry(Entry $entry)
    {
        $this->entries[] = $entry;
    }

    public function lookup($tubeName)
    {
        foreach ($this->entries as $entry) {
            if ($entry->contains($tubeName)) {
                return $entry->lookup($tubeName);
            }
        }
        throw new BeanstalkdExcetpion("fail to find host with {$tubeName}");
    }

    private function checkConfigs($configs)
    {
        foreach ($configs as $config) {
            if (ArrayTool::required($config, array('name', 'tubeNames', 'hosts'))) {
                throw new BeanstalkdExcetpion("Invalid config cause lack of params");
            }
        }
    }
}