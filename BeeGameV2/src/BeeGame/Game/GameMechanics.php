<?php

namespace BeeGame\Game;

use BeeGame\Container\BeeHiveProvider;
use BeeGame\Game\BeeHive;
use Pimple\Container;

/**
 * Class gameMechanics
 * @package beeGame\core
 */
class GameMechanics
{
    private static $pointer;

    /**
     * Initiate the game
     * @param beeHive $beeHive
     */
    public static function init(Container $container)
    {
        $container[BeeHiveProvider::NAME]->spawnBees();
        self::renderView('game.php', ['mt' => 0]);
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

        //printf('<h1> 🐝 %s bee at position %s took a hit!</h1>', $beeHive[self::$pointer]->type, self::$pointer);

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

        if (isset($beeHive) && count($beeHive) > 1) {
            $_SESSION['bees'] = $beeHive;
            self::renderView('game.php', ['mt' => 1, 'beeHive' => $beeHive]);
        } else {
            self::renderView('allDead.php');
        }
    }

    /**
     * render a view
     * @todo render the view/html method
     * @param $mt
     */
    private static function renderView($view, $data = [])
    {
        extract($data);
        $viewPath = realpath(__DIR__.'/../Views/'.$view);
        include_once($viewPath);
    }
}
