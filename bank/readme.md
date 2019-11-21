### Bank application :bank:
![version](https://img.shields.io/badge/php-7.2-blue.svg?logo=php) 
![tag](https://img.shields.io/badge/tag-bank_app-green.svg) 

A simple bank account management system.

The system allows the creation of new accounts, managing the account allowing deposits and withdrawals  and also manage a overdraft limit.

The application runs in the CLI .

Information is stored in a encrypted database file. 
Actions are logged.

#### You will need
 - php 7.0 or higher
 - composer
 - php running in the command line
 - openssl_encrypt 
 - phpunit 8
 - monolog


### Installation
 - unzip the files
 - head to the new created folder folder
 - run ```
       $ composer install
       ```
 
 
 ### Tests
 phpunit is installed as a composer dependency.
 
 You can run it globally, just head to the .../bank/tests/app folder and run
 ```
 $ phpunit accountTest.php --testdox 
 ```
 If you wish to use composer, from the same folder just run 

  ```
  $  ../../vendor/bin/phpunit accountTest.php --testdox
  ```
  
  
  ### Application
  #### start
  Inside bank run
    ```
    $  php init.php
    ```
  
  #### Considerations
  
  For the sake of simplicity, the accounts only use integer numbers
  
  It uses a simple menu system that outputs ascii characters for design menus
  
  #### Development
  
  Used PSR2 and PSR4 Autoload 
  
  Adapted MVC design
  
  Small sequential encrypted file as a database
  
  Majority of the application is private because is dealing with sensitive data
  
  Used monolog not to log application warnings but for user application behaviors 

  > You can find the log inside the logs folder -> `bankLog.log`

  > :bulb: A cron task running a AI script could read the log and look for strange patterns/behaviors like more than 4 withdrawals in 5 minutes or apply other rules and then trigger action accordingly.

  ```javascript
[2019-11-20 12:10:08] accounts.INFO: {Application started} [] []
[2019-11-20 12:10:23] accounts.INFO: {"account creation attempt":{"accountNumber":0}} [] []
[2019-11-20 12:10:28] accounts.INFO: {"account managing":"5dd52d2d77316"} [] []
[2019-11-20 12:10:31] accounts.INFO: {"Deposit funds accID":"5dd52d2d77316"} [] []
[2019-11-20 12:10:39] accounts.INFO: {"Display balance accID":"5dd52d2d77316"} [] []
[2019-11-20 12:10:42] accounts.INFO: {"Withdraw Funds accID":"5dd52d2d77316"} [] []
[2019-11-20 12:16:51] accounts.INFO: {"account managing":"5dd52d2d77316"} [] []
[2019-11-20 12:16:54] accounts.INFO: {"Withdraw Funds accID":"5dd52d2d77316"} [] []
[2019-11-20 12:17:03] accounts.INFO: {"Withdraw Funds accID":"5dd52d2d77316"} [] []
[2019-11-20 12:20:00] accounts.INFO: {"Display balance accID":"5dd52d2d77316"} [] []
...
  ```

  > You can find the DB file inside the dataBase folder -> `accounts.db`
  ```javascript
[{"acNumber":0,"acID":"5dd52d2d77316","acSensitive":"K0NuSjRmdlBBenBBMU1LZGthWUpwR0VEa..."}]
  ```
  
  #### Site tree
  
  - bank
    - app
        - controllers
        - core
        - db
        - models
        - settings
        - traits
        - views
    - database
        - accounts.db
    - logs
    - tests
    - vendor
    
    ## screens

Home:

<img src="https://preview.ibb.co/i3W2nH/home.png" width="348">

Open new account:

<img src="https://preview.ibb.co/ckeYux/open_account.png" width="348">

Enter manage accounts

<img src="https://preview.ibb.co/imXWgc/manage_account_0.png" width="348">

Manage accounts:

<img src="https://preview.ibb.co/kfy41c/manage_account_2.png" width="348">

Balance:

<img src="https://preview.ibb.co/eAiF7H/balance.png" width="348">
