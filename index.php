<?php

// Require stuff
require('vendor/autoload.php' );
require('config.php');

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

$zepto = new Zepto\Zepto($config);
$zepto->run();
