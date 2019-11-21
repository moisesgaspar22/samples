<?php

$phpVersion = explode('.', phpversion());

if ($phpVersion[0] < 7) {
    die('You need php 7.0 or higher to run this application.');
}

if (!php_sapi_name() == 'cli') {
    die('Application only works on command line.');
}

require_once 'vendor/autoload.php';
require_once 'app/settings/settings.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

new bankApp\core\bank();
