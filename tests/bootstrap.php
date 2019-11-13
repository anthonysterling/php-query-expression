<?php

date_default_timezone_set('UTC');

if (!file_exists(__DIR__.'/../vendor/autoload.php')) {
    echo 'Composer autoloader is not present; try running `composer install`.', PHP_EOL;
    exit(1);
}

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->setPsr4('AnthonySterling\\QueryExpression\Tests\\', __DIR__);
