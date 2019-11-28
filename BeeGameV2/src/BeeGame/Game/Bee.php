<?php

namespace BeeGame\Game;

/**
 * 🐝 small bee factory
 * Class bee
 * @package beeGame
 */
class Bee
{
    /**
     * @var integer
     */
    private $lifeSpan;

    /**
     * @var integer
     */
    private $hitPoints;

    /**
     * @var boolean
     */
    private $killAll;

    /**
     * @var string
     */
    public $type;

    /**
     * @var integer
     */
    public $status = 1;

    /**
     * build me a bee!!
     * bee constructor.
     * @param $dna array | like a manifest or build instructions blue print
     */
    public function __construct($dna)
    {
        $this->type      = $dna['type'];
        $this->hitPoints = $dna['hitPoints'];
        $this->killAll   = $dna['killAll'];
        //set method
        $this->setLifeSpan($dna['lifeSpan']);
    }

    /**
     * @param $lifeSpan
     * @return integer
     */
    private function setLifeSpan($lifeSpan)
    {
        if ($lifeSpan <= 0) {
            $this->status   = 0;
            $this->lifeSpan = -1;
            return false;
        }
        $this->lifeSpan = $lifeSpan;
    }

    /**
     * @return mixed
     * @return integer
     */
    public function getLifeSpan()
    {
        return $this->lifeSpan;
    }

    /**
     * deals with the bee lifespan
     * setter method
     * @return void
     */
    public function takeHit()
    {
        $life = $this->getLifeSpan();
        $this->setLifeSpan($life - $this->hitPoints);
    }

    /**
     * ☠️ kill all bees
     * @return boolean
     */
    public function getKillAll()
    {
        return $this->killAll;
    }
}
