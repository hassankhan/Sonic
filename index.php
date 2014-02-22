<?php

// Require stuff
require('vendor/autoload.php' );
require('config.php');

$zepto = new Zepto\Zepto($config);
$zepto->run();
