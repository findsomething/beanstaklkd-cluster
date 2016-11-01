<?php
/**
 * Created by PhpStorm.
 * User: lihan
 * Date: 16/11/1
 * Time: 16:13
 */
namespace FSth\BeanstalkdCluster\Tool;

class ArrayTool
{
    public static function required(array $array, array $keys)
    {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $array)) {
                return false;
            }
        }
        return true;
    }
}