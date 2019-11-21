<?php
/**
 * closed account message
 */
$html = <<<HTML
┌───────────────────────────────────────────────┐
│            \033[0;32m Manage Account \033[0m                   │       
├──────────────────────┬────────────────────────┤
│        This bank account is now closed        │
└───────────────────────────────────────────────┘
HTML;
echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
echo $html, PHP_EOL;
readline('press enter to go back');
