<?php

namespace beeGame\core;

use beeGame\beeHive;

/**
 * Class gameMechanics
 * @package beeGame\core
 */
class gameMechanics
{
    private static $pointer;

    /**
     * TDD uhm!! always
     * Initiate the game
     * @param beeHive $beeHive
     */
    public static function init(beeHive $beeHive)
    {
        $beeHive->spawnBees();
        self::renderView(0);
    }

    /**
     * manage hits
     * @return void
     */
    public static function hitBee()
    {
        //@todo create a class to manage session vars
        $beeHive       = $_SESSION['bees'];
        self::$pointer = rand(0, sizeof($beeHive)-1);

        printf('<h1> 🐝 %s bee at position %s took a hit!</h1>', $beeHive[self::$pointer]->type, self::$pointer);

        $beeHive[self::$pointer]->takeHit();

        if (!$beeHive[self::$pointer]->status) {
            if ($beeHive[self::$pointer]->getKillAll()) {
                unset($beeHive);
                echo '<h1>The queen is dead! Long live the queen!</h1>';
            } else {
                unset($beeHive[self::$pointer]);
                $beeHive = array_values($beeHive);
            }
        }

        unset($_SESSION['bees']);

        if (isset($beeHive)) {
            $_SESSION['bees'] = $beeHive;
            self::renderView(1);
        } else {
            $html = <<<HTML
                <h2>All bees are dead !!</h2>
                <hr/>
                <form action="index.php">
                    <button type="submit" id="restart_bee">Restart hitting</button>
                </form>
HTML;
            echo $html;
        }
    }

    /**
     * render a view
     * @todo render the view/html method
     * @param $mt
     */
    private static function renderView($mt)
    {
        foreach ($_SESSION['bees'] as $position => $mBee) {
            $clsClass = (($position == self::$pointer) && $mt) ? $clsClass = 'bee_hit': '';
            echo '<span class="'.$clsClass.'">';
            //just basic standard output is required , no fancy css ;-)
            print_r($mBee);
            echo '</span>';
            echo'<br>';
        }
        $html = <<<HTML
            <hr/>
            <form action="index.php" method="post">
                <button type="submit" id="hit_bee">Hit random bee</button>
            </form>
HTML;
        echo $html;
    }
}
