<?php

// Require stuff
require('vendor/autoload.php' );

$zep = new Zepto\Console($argv);

$zep->param('option',     'Choose from init or new', true);
$zep->param('new_option', 'Choose from plugin or content');

if(!$zep->parse()) {
    exit(1);
}

if ($zep->get('option') === 'init') {
    $zep->out('init');
    // do init shit
}
elseif ($zep->get('option') === 'new') {
    $zep->out('new');
    // do new shit
}
