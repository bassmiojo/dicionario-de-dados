<?php


/**
 * Created by PhpStorm.
 * User: USER
 * Date: 21/11/2016
 * Time: 10:46
 */
namespace App\DataBases;


class Mysql
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



        $model = new Conection("mysql", $dataConection["host"], $dataConection["db_name"], $dataConection["user"], $dataConection["password"]);

        $this->instance_con = $model->con;

        $tables = $this->get_table($dataConection["db_name"]);

        foreach ($tables as $row) {

            $tables_name=$row["TABLE_NAME"];
            $this->data[$tables_name]["title"] = $tables_name;
            $column = $this->get_column($tables_name);

            $this->data[$tables_name]["column"] = $this->tratar_column($column);
        }


        return $this;

    }

    public function get_table($db_name)
    {
        $result = $this->instance_con->query("SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = '".$db_name."';");
        $result->execute();
        return $result->fetchAll();


    }

    public function get_column($table)
    {
        $result = $this->instance_con->query("select * from information_schema.columns where table_name ='{$table}'");
        $result->execute();
        return $result->fetchAll();
    }

    public function tratar_column($column)
    {

        $data_column = array();
        $contador =1;
        foreach ($column as $row) {
            /* nome da coluna*/
            $data_column[$contador]["indice"] = $contador;
            $data_column[$contador]["column_name"] = $row["COLUMN_NAME"];

            /* tipo do dado*/
            $data_column[$contador]["data_type"] = $row["DATA_TYPE"];

            /*quantidade de caracteres*/
            if (!empty($row["CHARACTER_MAXIMUM_LENGTH"])) {
                $data_column[$contador]["character_maximum_length"] = "(" . $row["CHARACTER_MAXIMUM_LENGTH"] . ")";
            }else{
                $data_column[$contador]["character_maximum_length"]="";
            }

            /*se é nulo ou não*/
            if ($row["IS_NULLABLE"] == 'NO'){
                $data_column[$contador]["is_nullable"]="Não Nulo";
            }else{
                $data_column[$contador]["is_nullable"]="";
            }
            $contador++;
        }

        return $data_column;

    }
}