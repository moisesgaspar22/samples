<?php
// Please run composer install from the command line
require_once 'vendor/autoload.php';

session_start();

// Let the games begin :-)
(new BeeGame\app())->init();
