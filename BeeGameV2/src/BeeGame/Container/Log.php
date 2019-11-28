<?php

namespace BeeGame\Container;

use Pimple\Container;
use BeeGame\Logging\JustLog;

class Log extends Provider
{
    const LOGGER   = 'logger.log';
    const LOG_PATH = 'logger.log_path';

    /**
     * @param Container $container
     */
    public function register(Container $container)
    {
        $container[ self::LOG_PATH ] = function (Container $container) {
            return 'logs/app/debug.log';
        };

        $container[ self::LOGGER ] = function (Container $container) {
            return new JustLog($container[ self::LOG_PATH ]);
        };
    }
}
