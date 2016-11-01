<?php
/**
 * Created by PhpStorm.
 * User: lihan
 * Date: 16/11/1
 * Time: 14:44
 */
namespace FSth\BeanstalkdCluster\Test\Business;

use FSth\BeanstalkdCluster\Business\Entry;

class EntryTest extends \PHPUnit_Framework_TestCase
{
    private $tubeNames;
    private $configs;

    private $entry;

    private $name = "testName";

    public function setUp()
    {
        $this->tubeNames = array(
            'tubeName1', 'tubeName2', 'tubeName3'
        );

        $this->configs = array(
            array('host' => '127.0.0.1', 'port' => 11300),
            array('host' => '127.0.0.1', 'port' => 11301)
        );

        $this->entry = new Entry($this->name, $this->tubeNames, $this->configs);
    }

    public function testGet()
    {
        $tubeName = $this->tubeNames[0];
        $config = $this->entry->get($tubeName);
        var_dump($config);

        $tubeName = $this->tubeNames[1];
        $config = $this->entry->get($tubeName);
        var_dump($config);

        $tubeName = $this->tubeNames[2];
        $config = $this->entry->get($tubeName);
        var_dump($config);
    }
}