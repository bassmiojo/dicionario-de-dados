<?php


/**
 * Created by PhpStorm.
 * User: USER
 * Date: 21/11/2016
 * Time: 10:46
 */
namespace App\DataBases;


class Postgres
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


     
        $model = new Conection("pgsql", $dataConection["host"], $dataConection["db_name"], $dataConection["user"], $dataConection["password"]);

        $this->instance_con = $model->con;
        
        $tables = $this->get_table();

        foreach ($tables as $row) {



            $tables_name = $row["tablename"];
            $this->data[$tables_name]["title"] = $tables_name;
            $column = $this->get_column($tables_name);

            $this->data[$tables_name]["column"] = $this->tratar_column($column);


        }
        
        return $this;

    }

    public function get_table()
    {
        $result = $this->instance_con->query("Select * from pg_tables where schemaname='public'");
        $result->execute();
        return $result->fetchAll();


    }

    public function get_column($table)
    {
        $result = $this->instance_con->query("SELECT * FROM information_schema.columns where table_name='{$table}'");
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
            $data_column[$contador]["column_name"] = $row["column_name"];

            /* tipo do dado*/
            $data_column[$contador]["data_type"] = $row["data_type"];

            /*quantidade de caracteres*/
            if (!empty($row["character_maximum_length"])) {
                $data_column[$contador]["character_maximum_length"] = "(" . $row["character_maximum_length"] . ")";
            }else{
                $data_column[$contador]["character_maximum_length"]="";
            }

            /*se é nulo ou não*/
            if ($row["is_nullable"] == 'NO'){
                $data_column[$contador]["is_nullable"]="Não Nulo";
            }else{
                $data_column[$contador]["is_nullable"]="";
            }
            $contador++;
        }

        return $data_column;

    }
}