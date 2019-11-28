<?php

namespace BeeGame\Container;

use Pimple\Container;
use BeeGame\Game\BeeHive;

class BeeHiveProvider extends Provider {

    const NAME  = 'bee.hive.name';

    /**
     * @param Container $container
     */
    public function register( Container $container ) {
        $container[ self::NAME ] = function ( Container $container ) {
            return  new BeeHive($container);
        };
    }
}
