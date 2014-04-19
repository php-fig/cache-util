<?php

namespace Psr\Cache;

// This is strictly so that we can work on these packages without publishing
// them yet. This whole file will eventually be removed.
require_once '../psr-cache/vendor/autoload.php';
require_once 'vendor/autoload.php';

date_default_timezone_set('America/Chicago');

$pool = new MemoryPool();

$item = $pool->getItem('foo');
$item->save('foo value', '300');
$item = $pool->getItem('bar');
$item->save('bar value', '300');


/*
foreach ($pool->getItems(['foo', 'bar']) as $item) {
    printf("%s: %s\n", $item->getKey(), $item->get());
}

$items = $pool->getItems(['foo', 'bar']);

$items['bar']->set('new bar value');
$items->save();

foreach ($pool->getItems(['foo', 'bar']) as $item) {
    printf("%s: %s\n", $item->getKey(), $item->get());
}
*/

/*
$item = $pool->getItem('baz')->set('baz value');
$collection = $pool->getItems(['foo', 'bar']);
$collection[] = $item;
$collection->save();

foreach ($pool->getItems(['foo', 'bar', 'baz']) as $item) {
    printf("%s: %s\n", $item->getKey(), $item->get());
}
*/
