# appName
Template Symfony 5.1 Application

Local Development
=================

## Pre-Requisites

* Mac OS: Install Homebrew: https://brew.sh
  * brew install php@7.4
  * brew install mysql@5.7
  * brew install composer
  * brew install sqlite
* Install Symfony executable:
  * https://symfony.com/download

## Pre-Install

* Securely Install MySQL Locally:
  * **mysql_secure_installation**
    * follow the prompts
* Start MySQL:
  * Mac OS:
    * **mysql.server start**

## Installation

* **git clone the repo**
* **cd appName**
* **mysql -u root -p**
    * (enter the password you created during mysql_secure_installation)
    * > create database appName;
    * > exit
* if you did set a password for the root user on your local database then do this:
  * Skip this step if you did not set a password on your local database
  * create a **.env.local** file
  * add a line like this:
    * DATABASE_URL=mysql://root:YOURPASSWORD@127.0.0.1:3306/appName?serverVersion=5.7
* **composer install**
* **./bin/console doctrine:migrations:migrate**
  * enter "y" to proceed
* **./vendor/bin/phpunit**
* open a new shell window into the same "appName" directory
  * in that shell, run this:
    * **symfony server:start**
* Back in the original shell, run this:
  * **./vendor/bin/codecept run**
* In a browser, open: https://localhost:8000/api/doc

    
