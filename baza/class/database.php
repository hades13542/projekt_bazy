<?php

/**
 * Created by PhpStorm.
 * User: atar1x
 * Date: 05.01.16
 * Time: 00:13
 */
class database
{
    static $conn_string = 'host=pellefant-01.db.elephantsql.com dbname=xmvwbdee user=xmvwbdee password=ge3juV_jk0VgFE2VrDgD-ZOi9D2J5hHp';
    //static $conn_string = 'host=pellefant-01.db.elephantsql.com dbname=kgkxlucn user=kgkxlucn password=-mz6ZfLVObAUKIW0rngT0MJSLKJVBgY_';
    protected static $dbconn;
    private $sql;
    function __construct()
    {
        self::$dbconn = pg_connect(self::$conn_string) or die('Nie mozna polaczyc z baza' . pg_last_error());
    }

    public function listAll(){
        $this->sql = 'select * from gra';
        $result = pg_query($this->sql) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;

    }

    public function saveKategorie($obj){
        $res = pg_query_params("insert into kategoria (nazwa) values ($1);", Array($obj->nazwa));
        return $res;
    }

    public function saveSimple($obj){
        $res = pg_query_params("insert into gra (nazwa,data_wydania,opis,ocena,multiplayer) values ($1,$2,$3,$4,$5);", Array($obj->nazwa,$obj->data_wydania,$obj->opis,$obj->ocena,$obj->multiplayer));
        return $res;
    }

    public function search($obj){
        $res = pg_query_params("select * from gra where nazwa like $1;", Array($obj->nazwa));
        return pg_fetch_all($res);

    }
    public function saveRec($obj){

        $res = pg_query_params("insert into aaa (idtable_01,name) values ($1,$2);", Array($obj->idtable_01,$obj->name));
        return $res;

    }
}

