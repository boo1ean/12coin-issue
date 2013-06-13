<?php
namespace Mint;

require_once 'Coin.php';
require_once 'Heap.php';
require_once 'Strategy.php';


function iterate($size) {
    return 'Fake element at ' . $size . PHP_EOL;
}


$finish = 13;
$fake = 100;

for ($size = 1; $size < $finish; ++$size) {
    echo 'Size: ' . $size . PHP_EOL;
    echo PHP_EOL;
    for ($i = 0; $i < $size; ++$i) {

        echo iterate($i);

        $heap = Heap::generate($size);
        $heap->at($i)->setWeight($fake);

        $strategy = new Strategy($heap);
        $result   = $strategy->exec();

        if ($result->getWeight() != $fake || $strategy->getCount() > 3) {
            throw new \LogicException('Your algorithm sucks!');
        }
    }

    echo PHP_EOL . PHP_EOL;
}

echo PHP_EOL . 'YOU WIN!' . PHP_EOL;
