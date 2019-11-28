<?php

namespace BeeGame\Container;

use Pimple\Container;
use BeeGame\Game\GameMechanics;

class GameMechanicsProvider extends Provider
{
    const NAME         = 'game.name';
    const NAME_INIT    = 'game.init';
    const NAME_HIT_BEE = 'game.hit.bee';

    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container[ self::NAME ] = function (Container $container) {
            return  new GameMechanics();
        };

        $container[ self::NAME_HIT_BEE ] = function (Container $container) {
            return  $container[ self::NAME ]::hitBee();
        };

        $container[ self::NAME_INIT ] = function (Container $container) {
            return  $container[ self::NAME ]::init($container);
        };
    }
}
