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

function bench($value, $n = 1000000) {
    $benchmark = new Benchmark;

    $benchmark->add('serialize',   function() use (&$value) {
        serialize($value);
    });

    $benchmark->add('json_encode',   function() use (&$value) {
        json_encode($value);
    });

    if (function_exists('bin_encode')) {
        $benchmark->add('bin_encode',   function() use (&$value) {
            bin_encode($value);
        });
    }

    if (function_exists('bson_encode')) {
        $benchmark->add('bson_encode',   function() use (&$value) {
            bson_encode($value);
        });
    }

    if (function_exists('msgpack_pack')) {
        $benchmark->add('msgpack_pack',   function() use (&$value) {
            msgpack_pack($value);
        });
    }

    if (function_exists('igbinary_serialize')) {
        $benchmark->add('igbinary_serialize',   function() use (&$value) {
            igbinary_serialize($value);
        });
    }

    $benchmark->add('var_export',   function() use (&$value) {
        var_export($value, true);
    });

    $benchmark->setCount($n);
    $benchmark->run();
}

echo "Serialize Array " . PHP_EOL;
bench([
    'test' => 1,
    'test2' => true,
    'test3' => false,
    'test4' => 123456789,
    'test5' => 123456789.0,
    'test6' => [1,2,3,4,5,6,7,8,9]
]);

$class = new \stdClass();
$class->property1 = true;
$class->property2 = false;
$class->property3 = "test string";
$class->property4 = 1;
$class->property5 = 1.0;

echo PHP_EOL . "Serialize stdClass " . PHP_EOL;
bench($class);

echo PHP_EOL . "Serialize Array with 10000 integer(s)" . PHP_EOL;
bench(range(1, 10000), 1000);
