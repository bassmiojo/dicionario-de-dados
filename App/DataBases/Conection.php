<?php


/**
 * Created by PhpStorm.
 * User: USER
 * Date: 21/11/2016
 * Time: 10:46
 */
namespace App\DataBases;


class Conection
{

    public $con;

    public function __construct($type, $host, $db_name, $user_name, $password)
    {



        try {
            $this->con = new \PDO("{$type}:Server={$host};Database={$db_name}", $user_name, $password);

        } catch (PDOException $e) {
            echo $e->getMessage();

        }


    }

}