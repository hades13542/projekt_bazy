<?php

/**
 * Created by PhpStorm.
 * User: atar1x
 * Date: 05.01.16
 * Time: 00:13
 */
class database
{
    //static $conn_string = 'host=pellefant-01.db.elephantsql.com dbname=xmvwbdee user=xmvwbdee password=ge3juV_jk0VgFE2VrDgD-ZOi9D2J5hHp';
    static $conn_string = 'host=pellefant-01.db.elephantsql.com dbname=kgkxlucn user=kgkxlucn password=-mz6ZfLVObAUKIW0rngT0MJSLKJVBgY_';
    protected static $dbconn;
    private $sql;
    function __construct()
    {
        self::$dbconn = pg_connect(self::$conn_string) or die('Nie mozna polaczyc z baza' . pg_last_error());
    }

    public function listAll(){
        $this->sql = 'select * from aaa';
        $result = pg_query($this->sql) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }
}

