<?php
/**
 * User: Marek Kebza <marek@kebza.cz>
 * Date: 06/08/2017
 * Time: 16:31
 */

$file = __DIR__.'/../vendor/autoload.php';
if (!file_exists($file))
{
    $file = __DIR__.'/../../../../vendor/autoload.php';
    if (!file_exists($file))
        throw new RuntimeException('Install dependencies to run test suite.');
}

$autoload = require_once $file;