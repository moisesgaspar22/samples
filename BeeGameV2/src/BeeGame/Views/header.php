<?php
// Header partial
if (empty($beeHive[self::$pointer])) {
    printf('<h1> 🐝 Let\'s start hitting some bees</h1>');
} else {
    printf('<h1> 🐝 %s bee at position %s took a hit!</h1>', $beeHive[self::$pointer]->type, self::$pointer);
}
