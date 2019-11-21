<?php
/**
 * get account number view
 */
$html = <<<HTML
┌───────────────────────────────────────────────┐
│            \033[0;32m Manage Account \033[0m                   │       
├──────────────────────┬────────────────────────┤
│         Please insert account number          │
└───────────────────────────────────────────────┘
HTML;
echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
echo $html, PHP_EOL;
