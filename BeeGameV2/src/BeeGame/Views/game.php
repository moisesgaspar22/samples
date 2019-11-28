<?php
self::renderView('header.php');

foreach ($_SESSION['bees'] as $position => $mBee) {
            $clsClass = (($position == self::$pointer) && $data['mt']) ? $clsClass = 'bee_hit': '';
            echo '<span class="'.$clsClass.'">';
            //just basic standard output is required , no fancy css ;-)
            print_r($mBee);
            echo '</span>';
            echo'<br>';
        }
?>
<hr/>
<form action="index.php" method="post">
    <button type="submit" id="hit_bee">Hit random bee</button>
</form>
