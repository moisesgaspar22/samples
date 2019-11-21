<?php

/** do settings */
declare(strict_types=1);

define('SITE_ROOT', dirname(__DIR__));
define('DB_FILE_LOCATION', dirname(SITE_ROOT));
define('DB_FILE_NAME', 'accounts.db');
define('DB_FILE', DB_FILE_LOCATION.DIRECTORY_SEPARATOR.'database'.DIRECTORY_SEPARATOR.DB_FILE_NAME);


define('SECRET_KEY', '_lM;O$8Qbl66J!A');
define('SECRET_KEY_IV', 'j&p^MR@g)!yz?a[');
