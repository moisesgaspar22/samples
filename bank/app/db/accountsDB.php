<?php
namespace bankApp\db;

use bankApp\core\account;

/**
 * Class accountsDB
 * @package bankApp\db
 */
class accountsDB
{
    /**
     * @param account $data
     * @return bool
     */
    public static function saveData(account $data)
    {
        $dataToFile[] = $data->getInfoToSave();

        $tempMem = self::allAccounts();
        if (!empty($tempMem)) {
            array_push($tempMem, $dataToFile[0]);
        } else {
            $tempMem = '';
            $tempMem = $dataToFile;
        }

        $newData = json_encode(array_values($tempMem));

        if (file_put_contents(DB_FILE, $newData) !== false) {
            return true;
        }

        return false;
    }

    /**
     * @param int $accountNumber
     * @return bool|mixed
     */
    public static function readData(int $accountNumber = -1)
    {
        //bail out sooner
        if ($accountNumber == -1) {
            return false;
        }

        foreach (self::allAccounts() as $account) {
            if ($account['acNumber'] === $accountNumber) {
                return $account;
            }
        }
        return false;
    }

    /**
     * @param account $data
     * @return bool
     */
    public static function updateData(account $data)
    {
        $allAccounts = self::allAccounts();
        foreach ($allAccounts as &$account) {
            if ($account['acNumber'] === $data->accountNumber) {
                $account = $data->getInfoToSave();
            }
        }
        if (self::saveAll($allAccounts)) {
            return true;
        }

        return false;
    }

    /**
     * @return void
     */
    public static function getNewAccountNumber()
    {
        $tempMem = self::allAccounts();
        if (empty($tempMem)) {
            return 0;
        }

        end($tempMem);
        return (key($tempMem) + 1);
    }

    /**
     * @return array|mixed
     */

     /**
      * @return mixed
      */
    private static function allAccounts()
    {
        $tempMem = json_decode(file_get_contents(DB_FILE), true);
        return $tempMem ?? [];
    }

    /**
     * @param $accounts
     * @return bool
     */
    private static function saveAll($accounts)
    {
        /**
         * @todo, implement a method that validates the data before save the information
         * this is sensitive data and should be checked always before saving
         * in a database you would be updating only one record
         * here we need to update the entire file
         */
        try {
            $newData = json_encode(array_values($accounts));
            file_put_contents(DB_FILE, $newData);
            return true;
        } catch (\Exception $e) {
            readline('I was unable to save the data! '.$e);
            return false;
        }
    }
}
