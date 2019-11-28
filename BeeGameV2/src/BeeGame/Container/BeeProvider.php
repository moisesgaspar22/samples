<?php

namespace BeeGame\Container;

use Pimple\Container;
use BeeGame\Game\Bee;

class BeeProvider extends Provider {

    const NAME                 = 'bee.name';
    const ADN                  = 'bee.adn';
    const FACTORY_INSTRUCTIONS = 'bee.bluprints';
    const INSTRUCTIONS_PATH    = 'bee.instructions.path';

    /**
     * @param Container $container
     */
    public function register( Container $container ) {

        $container[self::FACTORY_INSTRUCTIONS] = function(container $container){
            return include($container[self::INSTRUCTIONS_PATH]);
        };

        // Bee factory
        $container[self::NAME] = $container->factory(
            function ( Container $container ) {
                return  new Bee($container[ self::ADN ]);
            }
        );
    }
}
