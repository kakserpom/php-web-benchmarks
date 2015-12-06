<?php
/**
 * Created by PhpStorm.
 * User: ovr
 * Date: 06.12.15
 * Time: 22:26
 */

use Lavoiesl\PhpBenchmark\Benchmark;
use Ovr\Bench\AssignOrNot\ReturnAfterAssignProperty;
use Ovr\Bench\AssignOrNot\ReturnWithoutAfterAssignProperty;

include_once __DIR__ . '/vendor/autoload.php';

$benchmark = new Benchmark;

$value = [
    'test' => 1,
    'test2' => true,
    'test3' => false,
];

$benchmark->add('serialize',   function() use (&$value) {
    serialize($value);
});

$benchmark->add('json_encode',   function() use (&$value) {
    json_encode($value);
});

$benchmark->setCount(10000000);
$benchmark->run();