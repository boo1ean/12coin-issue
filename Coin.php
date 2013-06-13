<?php namespace Mint;
class Coin
{
    protected $weight;
    protected $id;

    public function __construct($weight = 0) {
        $this->setWeight($weight);
        $this->generateId();
    }

    /**
     * Returns coin's weight
     * @return integer weight value
     */
    public function getWeight() {
        return $this->weight;
    }

    /**
     * Set coin's weight
     *
     * @param integer $weight
     */
    public function setWeight($weight) {
        return $this->weight = intval($weight);
    }

    /**
     * Generate id for current coin
     */
    protected function generateId() {
        return $this->id = md5(uniqid());
    }
}
