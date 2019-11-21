<style> .bee_hit{color:red}; </style>
<?php

require_once('vendor/autoload.php');

use \beeGame\core\gameMechanics as game;
use \beeGame\beeHive;

session_start();

if (!empty($_SESSION['bees'])) {
    game::hitBee();
} else {
    game::init(new beeHive());
}
