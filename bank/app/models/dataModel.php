<?php

namespace bankApp\models;

use bankApp\core\account;
use bankApp\core\bank;
use bankApp\controllers\mainPageController as ctrlr;
use bankApp\db\accountsDB as dataBase;

class dataModel
{

    const DEPOSIT  = 'deposited';
    const WITHDRAW = 'withdraw';

    /**
     * 🙈
     * @param $data
     * @return bool|mixed
     */
    public function __invoke($data)
    {
        if (!empty($data) && (sizeof($data) >= 2)) {
            if (method_exists($this, $data[0])) {
                return call_user_func_array([$this, $data[0]], $data[1]);
            }
        }
        return false;
    }

    /**
     * @param array $data
     * @param account $nAccount
     * @return bool
     */
    private function newAccount(
        $data = [],
        account $nAccount = null
    ) {
        do {
            echo chr(27).chr(91).'H'.chr(27).chr(91).'J';
            ctrlr::getInstance()->view('newAccount', $data);
            $data['name']    = readline("Cliente name: ");
            $data['address'] = readline("Cliente Adress: ");
            $confirm = strtoupper(readline("Is this data valid? [y/Y to confirm | x/X to cancel | other key to change ] "));
        } while ($confirm != 'Y' && $confirm != 'X');

        if ($confirm == 'X') {
            return false;
        }

        $data['accountID'] = uniqid();

        //the object deals with the object, not data
        $nAccount = $nAccount ?? new account();
        $nAccount->createNewAccount($data);
        //The model deals with data
        $this->saveAccount($nAccount);
    }

    /**
     * @param account $obj
     * @return bool
     */
    private function saveAccount(account $obj)
    {
        if (dataBase::saveData($obj)) {
            echo "Your account number is \e[1;34m{$obj->accountNumber}\e[0m \n";
            readline("Account created, press any key to continue ");
            return true;
        } else {
            echo 'Sorry but something went wrong with the database file.. Permissions? Readonly?';
            readline();
            return false;
        }
    }

    /**
     * @return integer|boolean
     */
    private function getNewAccountNumber()
    {
        return dataBase::getNewAccountNumber() ?? false;
    }

    /**
     * @param int $acNumber
     * @return bool|mixed
     */
    private function getAccountFromDB(int $acNumber)
    {
        return dataBase::readData($acNumber);
    }

     /**
      * @param account $account
      * @return void
      */
    private function updateAccount(account $account)
    {
        return dataBase::updateData($account);
    }

    /**
     * displays balance
     * @return void
     */
    private function displayBalance()
    {
        $totalAvailable = $_SESSION['account']->getOverdraftLimit() + $_SESSION['account']->getFunds();
        echo "Funds : \e[0;32m {$_SESSION['account']->getFunds()} £\e[0m", PHP_EOL;
        echo "Funds available including your \e[0;32m {$_SESSION['account']->getOverdraftLimit()} £ \e[0m overdraft : \e[0;32m {$totalAvailable} £\e[0m", PHP_EOL;
        readline('press enter to continue');
    }

    /**
     * @param int $type
     * @return bool
     */
    private function depositFunds(int $type = 1)
    {
        switch ($type) {
            case 1:
                $wordType = self::DEPOSIT;
                break;
            case -1:
                $wordType = self::WITHDRAW;
                break;
            default:
                return false;
        }

        do {
            $amount = readline('Please insert a positive amount >0 to be '.$wordType.' or [x/X] to leave: ');
            if (strtoupper($amount) == 'X') {
                return false;
            }
        } while (!is_numeric($amount) || $amount <= 0);

        if ($_SESSION['account']->setFunds($amount * $type)) {
            echo "{$wordType} done, your funds are now :  \033[0;32m ".$_SESSION['account']->getFunds()."£ \033[0m", PHP_EOL;
        } else {
            echo "Insuficient funds! ", PHP_EOL;
        }

        readline('Press enter to continue');
        bank::$accountChanged = true;
    }

    /**
     * @return bool
     */
    private function applyOverdraft()
    {
        do {
            $amount = readline('Please insert the overdraft limit or [x/X] to leave: ');
            if (strtoupper($amount) == 'X') {
                return false;
            }
        } while (!is_numeric($amount));

        $_SESSION['account']->setOverdraftLimit($amount);
        echo "Your overdraft is now :  \033[0;32m {$_SESSION['account']->getOverdraftLimit()} £ \033[0m", PHP_EOL;
        readline('Press enter to continue');
        bank::$accountChanged = true;
    }

    /**
     * @param int $type
     * @return void;
     */
    private function closeAccount()
    {
        $_SESSION['account']->accountState = 0;
        bank::$accountChanged              = true;
    }
}
