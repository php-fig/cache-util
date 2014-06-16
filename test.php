<?php

namespace Psr\Cache;

// This is strictly so that we can work on these packages without publishing
// them yet. This whole file will eventually be removed.
require_once '../psr-cache/vendor/autoload.php';
require_once 'vendor/autoload.php';

date_default_timezone_set('America/Chicago');

$pool = new MemoryPool();

$item = $pool->getItem('foo');
$item->set('foo value', '300');
$pool->save($item);
$item = $pool->getItem('bar');
$item->set('bar value', new \DateTime('now + 5min'));
$pool->save($item);

foreach ($pool->getItems(['foo', 'bar']) as $item) {
    if ($item->getKey() == 'foo') {
        assert($item->get() == 'foo value');
    }
    if ($item->getKey() == 'bar') {
        assert($item->get() == 'bar value');
    }
}

$items = $pool->getItems(['foo', 'bar']);
$items['bar']->set('new bar value');
array_map([$pool, 'save'], $items);

foreach ($pool->getItems(['foo', 'bar']) as $item) {
    if ($item->getKey() == 'foo') {
        assert($item->get() == 'foo value');
    }
    if ($item->getKey() == 'bar') {
        assert($item->get() == 'new bar value');
    }
}



/*
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
