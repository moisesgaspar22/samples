<?php
/**
 * Create account
 */
echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
$html=<<<HTML
┌───────────────────────────────────────────────┐
│             \033[0;32m Create New Account \033[0m              │
└──────────────────────┬────────────────────────┘
      AC Number: {$data['accountNumber']}             
HTML;
echo $html, PHP_EOL;
