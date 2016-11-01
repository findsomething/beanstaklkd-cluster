# redis-client
```
beanstalkd cluster on client to distribute
```

# usage

```
$configs = array(
    array(
        'name' => 'test1',
        'tubeNames' => array('tubeName1', 'tubeName2'),
        'hosts' => array(
            array('host' => '127.0.0.1', 'port' => '11300'),
        )
    ),
    array(
        'name' => 'test2',
        'tubeNames' => array('tubeName3', 'tubeName4'),
        'hosts' => array(
            array('host' => '127.0.0.1', 'port' => '11301'),
            array('host' => '127.0.0.1', 'port' => '11302'),
        )
    )
);
$proxy = new \FSth\BeanstalkdCluster\Business\Proxy();
$proxy->initWithConfig($configs);

$host = $proxy->lookup('tubeName1'); // return array('host','port') port in ('11300');

$host = $proxy->lookup('tubeName3'); // return array('host','port') port in ('11301', '11302');
```

