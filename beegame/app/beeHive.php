<?php

namespace beeGame;

/**
 * Class beeHive
 * @package beeGame
 * bee factory
 */
class beeHive
{
    /**
     * bees manifest
     *
     * @var array
     */
    public $beeBluePrint;

    /**
     * beeHive constructor.
     */
    public function __construct()
    {
        //@todo file location should be a setting in a file
        $this->beeBluePrint = include('dnaFile.php');
        /**
         * here I'm injecting is own property, this way and because spanBees is public
         * I can use external dnaFiles to span different species of bees if needed
         */
        $this->spawnBees($this->beeBluePrint);
    }

    /**
     * @param $beeInstructionsBuild
     * @return bool|null
     * @todo implement a method to validate if the instructions are valid
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
                $beeHive[] = new bee($beeDna['dna']);
            }
        }

        //prevent same positions every time
        shuffle($beeHive);

        //pass objects to session
        $_SESSION['bees'] = $beeHive;

        return null;
    }
}
