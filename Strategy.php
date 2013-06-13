<?php namespace Mint;

function _log($msg) {
    echo PHP_EOL . $msg . PHP_EOL;
}
/**
 * @class
 * Represents solution for 12 coins task
 */
class Strategy
{
    protected $heap;
    protected $count = 0;

    /**
     * @param Heap $heap to process
     */
    public function __construct(Heap $heap) {
        $this->heap = $heap;
    }

    public function getCount() {
        return $this->count;
    }

    /**
     * Fire algorithm!
     *
     * @return mixed result
     */
    public function exec() {
        $size = ceil($this->heap->size() / 3);

        $left  = $this->heap->slice(0, $size);
        $right = $this->heap->slice($size, $size);
        $other = $this->heap->slice($size * 2);

        return $this->resolve($left, $right, $other);
    }

    /**
     * Recursively search for coin
     */
    protected function resolve($left, $right, $other) {
        $this->count++;
        $limit = ceil($left->size() / 2);
        $result = Heap::compare($left, $right);

        if ($left->size() + $right->size() <= 2 && (!$other || !$other->size())) {
            if (GREATER === $result) {
                return $left->at(0);
            } else {
                return $right->at(0);
            }
        }

        switch ($result) {
            case GREATER:
                if ($other && $other->size()) {
                    $ok = $other->at(0);
                }

                $right = $left->slice(0, $limit);
                $left  = $left->slice($limit);
            break;

            case LESS:
                if ($other && $other->size()) {
                    $ok = $other->at(0);
                }

                $left  = $right->slice(0, $limit);
                $right = $right->slice($limit);
            break;

            default:
                $ok = $left->at(0);
                if (!is_null($other)) {
                    $left  = $other->slice(0, $limit);
                    $right = $other->slice($limit);
                }
        }

        if ($left->size() < $right->size()) {
            $left->addCoin($ok);
        } else if ($right->size() < $left->size()) {
            $right->addCoin($ok);
        }

        return $this->resolve($left, $right, null);
    }
}
