<?php

namespace bankApp\core;

use bankApp\traits\support;

/**
 * Class account 🏦
 * @package bankApp\core
 * The application is too small don't see any need to create a parent or abstract class
 * as well for an interface.
 * This class is basically getters as setters/wrappers fallowing the encapsulation principle,
 * no complex logic here is required
 * Method names are self explanatory, no need for extra docBlocks
 * 
 * We do not want this to be extended!!
 */
final class account
{
    use support;

    /**
     * @var string
     */
    private $clientName;

    /**
     * @var string
     */
    private $clientAddress;

    /**
     * @var integer
     */
    public $accountNumber;

    /**
     * @var integer
     */
    private $clientAccountID;

    /**
     * @var integer
     */
    private $funds = 0;

    /**
     * @var integer
     */
    private $overdraftLimit = 0;

    /**
     * @var integer
     */
    public $accountState = 1;

    /**
     * 💳
     * @param integer $value
     */
    public function setOverdraftLimit(int $value)
    {
        $this->overdraftLimit = $value;
    }

    /**
     * 💸
     * @param int $funds
     * @return bool
     */
    public function setFunds(int $funds)
    {
        $tmpFunds = (($this->funds+$funds) * -1);
        
        if ($funds < 0 && $tmpFunds > $this->overdraftLimit) {
            return false;
        }

        $this->funds += $funds;
        return true;
    }

    /**
     * @param array $data
     * @return account
     */
    public function createNewAccount($data)
    {
        $this->clientName       = $data['name'];
        $this->clientAddress    = $data['address'];
        $this->clientAccountID  = $data['accountID'];
        $this->accountNumber    = $data['accountNumber'];

        return $this;
    }

    /**
     * @return integer
     */
    public function getFunds()
    {
        return $this->funds;
    }

    /**
     * @return integer
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @return string
     */
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * Vital information goes encrypted,🕵🏼‍♀️
     * also note that the object is encrypted and serialized
     * @return array
     */
    public function getInfoToSave()
    {
        return [
            'acNumber' => $this->accountNumber,
            'acID'     => $this->clientAccountID,
            'acSensitive' => self::dataCrypt(
                json_encode(
                    [
                        'acName'      => $this->clientName,
                        'acaddress'   => $this->clientAddress,
                        'acFunds'     => $this->funds,
                        'acOverDraft' => $this->overdraftLimit,
                        'acState'     => $this->accountState,
                        'acObj'       => serialize($this)
                    ]
                )
            )
        ];
    }

    /**
     * @return integer
     */
    public function getOverdraftLimit()
    {
        return $this->overdraftLimit;
    }

    /**
     * @return string
     */
    public function getClientAccountID()
    {
        return $this->clientAccountID;
    }
}
