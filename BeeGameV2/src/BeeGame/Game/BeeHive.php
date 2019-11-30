<?php

namespace BeeGame\Game;

use BeeGame\Container\BeeProvider;
use Pimple\Container;

/**
 * Class beeHive
 * @package beeGame
 * bee factory
 */
class BeeHive
{
    /**
     * bees manifest
     *
     * @var array
     */
    public $beeBluePrint;

    private $container;

    /**
     * beeHive constructor.
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->spawnBees($this->container[BeeProvider::FACTORY_INSTRUCTIONS]);
    }

    /**
     * @param $beeInstructionsBuild
     * @return bool|null
     */
    public function spawnBees($beeInstructionsBuild = [])
    {
        //no instructions to generate bees!!! 🐝
        if (empty($beeInstructionsBuild)) {
            return false;
        }

        //generate all bees! 🐝
        foreach ($beeInstructionsBuild as $beeDna) {
            for ($t= 1; $t<= $beeDna['amount']; $t++) {
                $this->container[BeeProvider::ADN] = $beeDna['dna'];
                $beeHive[]                         = $this->container[BeeProvider::NAME];
            }
        }

        //prevent same positions every time
        shuffle($beeHive);

        //pass objects to session
        $_SESSION['bees'] = $beeHive;

        return null;
    }
}
