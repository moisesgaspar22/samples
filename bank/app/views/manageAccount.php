<?php
/**
 * Manage account menu
 */
$menu = <<<HTML
\033[0;32m     Manage Account for {$_SESSION['account']->getClientName()} Acc nº: {$_SESSION['account']->getAccountNumber()}\033[0m
┌──────────────────────┬────────────────────────┐
│  1) Deposit funds    │  2) Apply overdraft    │
├──────────────────────┼────────────────────────┤
│  3) Display balance  │  4) Withdraw funds     │
├──────────────────────┴────────────────────────┤
│  5) Close this account                        │
├───────────────────────────────────────────────┤
│  6) Leave previous menu (Data Save)           │
└───────────────────────────────────────────────┘
HTML;
echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
echo $menu, PHP_EOL;
