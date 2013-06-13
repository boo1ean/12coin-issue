<?php namespace Mint;

const DEFAULT_NUMBER_OF_COINS = 12;

// Comparison results variants
const EQUAL   = 0;
const LESS    = -1;
const GREATER = 1;

class Heap
{
    protected $coins = array();

    public function __construct($coins = array()) {
        if (is_array($coins)) {
            foreach ($coins as $coin) {
                if ($coin instanceof Coin) {
                    $this->addCoin($coin);
                }
            }
        }
    }

    /**
     * Push new coin to array
     *
     * @param Coin single coin instance
     */
    public function addCoin(Coin $coin) {
        $this->coins[] = $coin;
        return $this;
    }

    /**
     * Creates new heap based on existing one
     *
     * @param integer $from start position
     * @param integer $count number of coins to slice
     * @return Heap new heap instance
     */
    public function slice($from, $count = 0) {
        if (0 === $count) {
            $count = count($this->coins) - $from;
        }

        return new static(array_slice($this->coins, $from, $count));
    }

    /**
     * Return amount of coins in heap
     * @return intger number of coins in current heap
     */
    public function size() {
        return count($this->coins);
    }

    /**
     * Returns element at specified offset
     * @param integer $offset
     * @return Coin
     */
    public function at($offset) {
        if ($offset < 0 || $offset >= count($this->coins)) {
            throw new \InvalidArgumentException(sprintf('Undefined offset: %d.', $offset));
        }

        return $this->coins[$offset];
    }

    /**
     * Pick some elements from heap and create new
     *
     * @param ... integer
     * @return Heap
     */
    public function pick() {
        $args = func_get_args();

        $coins = array();
        foreach ($args as $offset) {
            try {
                $coins[] = $this->at($offset);
            } catch (\InvalidArgumentException $e) {

            }
        }

        return new static($coins);
    }

    /**
     * Return array representation of heap
     * @return array
     */
    public function toArray() {
        return $this->coins;
    }

    /**
     * Get total weight of heap
     *
     * @return integer toal weight of all coins included in heap
     */
    public function getWeight() {
        $weight = 0;
        foreach ($this->coins as $coin) {
            $weight += $coin->getWeight();
        }

        return $weight;
    }

    /**
     * Compares two heaps and returns result:
     * -1 left is less
     * +1 left is greater
     * +0 heaps are equal
     *
     * @return integer
     */
    public static function compare(Heap $left, Heap $right) {
        $l = $left->getWeight();
        $r = $right->getWeight();

        if ($r === $l) {
            return EQUAL;
        } else if ($l < $r) {
            return LESS;
        } else {
            return GREATER;
        }
    }

    /**
     * Generate heap with specified number of coins
     *
     * @param integer $count number of coins to generate
     */
    public function generate($count = DEFAULT_NUMBER_OF_COINS) {
        $coins = array();
        for ($i = 0; $i < $count; ++$i) {
            $coins[] = new Coin();
        }

        return new static($coins);
    }
}
