<?php
self::renderView('header.php', ['beeHive' => $beeHive ??[]]);

foreach ($_SESSION['bees'] as $position => $mBee) {
            $clsClass = (($position == self::$pointer) && $data['mt']) ? $clsClass = 'bee_hit': '';
            printf('<span class="%s">', $clsClass);
            //just basic standard output is required , no fancy css ;-)
            print_r($mBee);
            printf('</span><br>');
}
?>
<hr/>
<form action="index.php" method="post">
    <button type="submit" id="hit_bee">Hit random bee</button>
</form>

<!-- Styling -->
<style> 
    .bee_hit{
        color:red
        }; 
</style>