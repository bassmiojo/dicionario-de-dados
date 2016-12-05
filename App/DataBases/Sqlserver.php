<?php


/**
 * Created by PhpStorm.
 * User: USER
 * Date: 21/11/2016
 * Time: 10:46
 */
namespace App\DataBases;


class Sqlserver
{

    private $data;
    private $instance_con;

    public function getData()
    {
        return $this->data;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function __construct($dataConection)
    {
        //$model = new Conection("pgsql", 'localhost', 'flex_wifi_dev', 'postgres', 'blstrs88');


        //print_r($dataConection);exit;
        $model = new Conection("sqlsrv", $dataConection["host"], $dataConection["db_name"], $dataConection["user"], $dataConection["password"]);

        $this->instance_con = $model->con;

        $tables = $this->get_table();

        foreach ($tables as $row) {



            $tables_name = $row["name"];

            $this->data[$tables_name]["title"] = $tables_name;
            $column = $this->get_column($tables_name);

            $this->data[$tables_name]["column"] = $this->tratar_column($column);


        }

        return $this;

    }

    public function get_table()
    {
        $result = $this->instance_con->query("SELECT * FROM SYSOBJECTS WHERE XTYPE='U'");

        return $result->fetchAll();


    }

    public function get_column($table)
    {

        $result = $this->instance_con->query("SELECT 
    COLUNAS.NAME AS COLUNA,
    TIPOS.NAME AS TIPO,
    COLUNAS.LENGTH AS TAMANHO,
    COLUNAS.ISNULLABLE AS EH_NULO
 
FROM 
    SYSOBJECTS AS TABELAS,
    SYSCOLUMNS AS COLUNAS,
    SYSTYPES   AS TIPOS
WHERE 
    -- JOINS 
    TABELAS.ID = COLUNAS.ID
    AND COLUNAS.USERTYPE = TIPOS.USERTYPE
    AND TABELAS.NAME = '$table'");
        //$result->execute();
        return $result->fetchAll();
    }

    public function tratar_column($column)
    {

        $data_column = array();
        $contador =1;
        foreach ($column as $row) {
            /* nome da coluna*/
            $data_column[$contador]["indice"] = $contador;
            $data_column[$contador]["column_name"] = $row["COLUNA"];

            /* tipo do dado*/
            $data_column[$contador]["data_type"] = $row["TIPO"];

            /*quantidade de caracteres*/
            if (!empty($row["TAMANHO"])) {
                $data_column[$contador]["character_maximum_length"] = "(" . $row["TAMANHO"] . ")";
            }else{
                $data_column[$contador]["character_maximum_length"]="";
            }

            /*se é nulo ou não*/
            if ($row["EH_NULO"]){
                $data_column[$contador]["is_nullable"]="Não Nulo";
            }else{
                $data_column[$contador]["is_nullable"]="";
            }
            $contador++;
        }

        return $data_column;

    }
}