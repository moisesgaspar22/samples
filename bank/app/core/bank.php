<?php
namespace bankApp\core;

use bankApp\controllers\mainPageController as ctrlr;
use bankApp\traits\support;
/** Logger */
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class bank
 * @package bankApp\core
 * Deals with the menu mechanics and actions
 */
class bank
{
    /**
     * support trait
     * contains the dataCrypt method
     */
    use support;

    /**
     * @var bool
     */
    public static $accountChanged = false;

    /**
     * @var |Log handler
     */
    public $log;

    /**
     * Handles all $this->sessionVar vars silently
     * @var object
     */
    protected $sessionVar;

    /**
     * bank constructor.
     */
    public function __construct()
    {
        // Log all your stuff!!
        $this->logger();
        $this->log->addInfo('{Application started}');

        //@todo -  Precursor to build a class to handle the session vars
        $this->sessionVar =  &$_SESSION;
        //bring Home menu to console
        $this->homeMenu();
    }

    /**
     * builds and manage the home menu
     */
    public function homeMenu()
    {
        do {
            do {
                $this->load()->view('homeMenu', []);
                $option = readline('Please insert your option [1 to 3]: ');
            } while ($option < 1 || $option >3);

            switch ($option) {
                case 1:
                    $this->createAccount();
                    break;
                case 2:
                    $this->manageMenu();
                    break;
                case 3:
                    echo "Leaving!";
                    break;
            }
        } while ($option != 3);
    }

    /**
     * builds and manage the manage menu
     * Only logging 1rst level information / basic information for
     * behavior analyses
     * details logs should be saved with values encrypted in the models
     */
    public function manageMenu()
    {
        do {
            do {
                $logic = isset($this->sessionVar['account']) ? 0 : $this->getAccountNumber();
                if (1 <=> $logic) {
                    if ($logic == -1) {
                        break 2;
                    }
                    if (!$this->sessionVar['account']->accountState) {
                        $this->load()->view('closedAccount', []);
                        break 2;
                    }
                    $this->load()->view('manageAccount', []);
                    $option = readline("Please insert your option [1 to 6]: ");
                }
            } while ($option < 1 || $option >6);
            $accountID = $this->sessionVar['account']->getClientAccountID();
            $this->manageMenuOptions($option, $accountID);
        } while ($option != 6);

        if (self::$accountChanged) {
            ctrlr::getInstance()->updateAccount($this->sessionVar['account']);
        }

        unset($this->sessionVar['account']);
    }

    /**
     *
     * @param int $option
     * @param int $accountID
     * @return void
     */
    protected function manageMenuOptions($option, $accountID)
    {
        switch ($option) {
            case 1:
                $this->log->addInfo(json_encode(['Deposit funds accID'   => $accountID]));
                ctrlr::getInstance()->depositFunds(1);
                break;
            case 2:
                $this->log->addInfo(json_encode(['Apply overdraft accID' => $accountID]));
                ctrlr::getInstance()->applyOverdraft();
                break;
            case 3:
                $this->log->addInfo(json_encode(['Display balance accID' => $accountID]));
                ctrlr::getInstance()->displayBalance();
                break;
            case 4:
                $this->log->addInfo(json_encode(['Withdraw Funds accID'  => $accountID]));
                ctrlr::getInstance()->depositFunds(-1);
                break;
            case 5:
                $this->log->addInfo(json_encode(['Close Funds accID'     => $accountID]));
                ctrlr::getInstance()->closeAccount(1);
                break;
            case 6:
                break;
        }
    }

    /**
     * @return int
     */
    public function getAccountNumber()
    {
        $this->load()->view('getAccountNumber', []);
        $option = readline("Account number: ");

        echo 'Press [x/X] to leave', PHP_EOL;
        if (!is_numeric($option)) {
            //bail out the menu
            if (strtoupper($option) == 'X') {
                return -1;
            }
            readline('Please insert a valid numerical account number! Press enter to continue');
            return 1;
        }
        
        if (!$acc = ctrlr::getInstance()->getAccountFromDB($option)) {
            readline("Account Number doesn't exists, press enter to go back");
            $this->log->addInfo(json_encode(['closed account managing attempt' =>$option]));
            return 1;
        }
        
        $acc            = ctrlr::getInstance()->getAccountFromDB($option);
        $sensitive      = json_decode(self::dataCrypt($acc['acSensitive'], 'd'));
        // hell yeah!! only from the final class !!!!! 👍🏼
        $accountSession = unserialize($sensitive->acObj, ["allowed_classes" => ["bankApp\\core\\account"]]);

        //I find this a good practice; 🙄
        unset($this->sessionVar['account']);
        $this->sessionVar['account'] = $accountSession;
        $this->log->addInfo(json_encode(['account managing' =>$acc['acID']]));
        return 0;
    }

    /**
     * 🏋🏻‍♂️
     * @return \bankApp\controllers\themeControllerRender|null
     */
    public function load()
    {
        return ctrlr::getInstance();
    }

    /**
     * trigger controller create new account
     * @return void
     */
    private function createAccount()
    {
        $nextAcAccountNumber = ['accountNumber' =>ctrlr::getInstance()->getNewAccountNumber()];
        ctrlr::getInstance()
            ->view('newAccount', $nextAcAccountNumber)
            ->newAccount($nextAcAccountNumber);
        $this->log->addInfo(json_encode(['account creation attempt' =>$nextAcAccountNumber]));
    }

    /**
     * always log your stuff 🤜🏻🤛🏻
     *
     * @return void
     */
    public function logger()
    {
        /**
         * Only logging accounts movements for behavior analysis
         * deposits, withdraws, all kind of actions are logged
         * then a ai script should read the logs every day at random hours to
         * search for strange and unwanted behavior and raise flags on actions
         *
         * Sensitive log information is saved encrypted
         */
        $this->log = new Logger('accounts');
        $this->log->pushHandler(new StreamHandler(LOGER_FILE, Logger::INFO));
    }
}
