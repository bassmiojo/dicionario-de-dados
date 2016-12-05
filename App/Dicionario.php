<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 21/11/2016
 * Time: 10:15
 */

namespace App;

use App\DataBases\Mysql;
use App\DataBases\Postgres;
use App\DataBases\Sqlserver;
use Exception;

class Dicionario
{

    private $DataBasesSuporte = ["postregres", "mysql", 'oracle',"sql_server"];
    private $DataBase;
    private $DataDicionary;
    private $host;
    private $db_name;
    private $user;
    private $password;

    public function init()
    {
        $this->validacoes();

        $retorno="";
        $dataConection=array(
            "host"=>$this->getHost(),
            "db_name"=>$this->getDbName(),
            "user"=>$this->getUser(),
            "password"=>$this->getPassword(),
        );

        if($this->getDataBase()=='postregres'){

            $Postgres = new Postgres($dataConection);
            $retorno= $Postgres->getData();
        }

        if($this->getDataBase()=='mysql'){
            $Postgres = new Mysql($dataConection);
            $retorno= $Postgres->getData();

        }
        if($this->getDataBase()=='sql_server'){
            $Postgres = new Sqlserver($dataConection);
            $retorno= $Postgres->getData();

        }




        $this->setDataDicionary($retorno);

        return $this;
    }
    public function getUser()
    {
        return $this->user;
    }


    public function setUser($user)
    {

        $this->user = $user;
        return $this;
    }
    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    public function getDbName()
    {
        return $this->db_name;
    }

    public function setDbName($db_name)
    {
        $this->db_name = $db_name;
        return $this;
    }

    public function getHost()
    {
        return $this->host;

    }

    public function setHost($host)
    {
        $this->host = $host;
        return $this;
    }
    public function getDataDicionary()
    {
        return $this->DataDicionary;
    }

    private function setDataDicionary($DataDicionary)
    {
        $this->DataDicionary = $DataDicionary;
    }

    public $debug = false;

    public function getDataBase()
    {
        return $this->DataBase;
    }

    public function setDataBase($DataBase)
    {
        $this->DataBase = $DataBase;
        return $this;
    }

    public function getDataBasesSuporte()
    {
        /* retorna os banco de dados suportados pela aplicaçação*/
        return $this->DataBasesSuporte;
    }

    private function DataBasesSuporteToString(){

        return implode(", ",$this->getDataBasesSuporte());
    }

    private function validaDataBases()
    {
        try {
            if (empty($this->getDataBase())) {
                throw new Exception("Banco de Dados não informado.");

            }
            if (!in_array($this->getDataBase(), $this->getDataBasesSuporte())) {

                $mensage = "<b>'".$this->getDataBase()."'</b> não é um Banco de Dados suportado.<br><br>";
                $mensage.= "<b> Banco de dados suportados: ".$this->DataBasesSuporteToString()."</b>";

                throw new Exception($mensage);

            }

            //|| $this->getDataBase()=='sql_server'
            if($this->getDataBase()=='oracle' ){
                throw new Exception("erro - banco de dados <b>'".$this->getDataBase()."'</b> ainda não foi implementado! ");
            }

        } catch (Exception $e) {
            echo $e->getMessage();
            exit;
        }
        return $this;
    }
    public function validacoes()
    {

        $this->validaDataBases();
        return $this;
    }
}