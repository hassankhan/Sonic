<?php

// Require stuff
require('vendor/autoload.php' );
require('config.php');

$sonic = new Sonic\Sonic($config);
$sonic->app['router']->route(new Sonic\Route\TagRoute('/tags/<:tag_name>'));
$sonic->run();
