<?php

    error_reporting(-1);
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);

    date_default_timezone_set('Europe/London');

    require_once realpath(__DIR__ . '/../vendor/autoload.php');

    define('ROOT_DIR', realpath(dirname(__FILE__) . '/..') . '/');
