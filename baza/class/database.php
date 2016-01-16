<?php


/**
 * Class database zarzadzająca wszelakimi operacjami w bazie
 */
class database
{
    /**
     * @var string
     */
    static $conn_string = 'host=pellefant-01.db.elephantsql.com dbname=xmvwbdee user=xmvwbdee password=ge3juV_jk0VgFE2VrDgD-ZOi9D2J5hHp';
    //static $conn_string = 'host=pellefant-01.db.elephantsql.com dbname=kgkxlucn user=kgkxlucn password=-mz6ZfLVObAUKIW0rngT0MJSLKJVBgY_';
    /**
     * @var resource
     */
    protected static $dbconn;
    /**
     * @var
     */
    private $sql;

    /**
     * database constructor.
     */
    function __construct()
    {
        self::$dbconn = pg_connect(self::$conn_string) or die('Nie mozna polaczyc z baza' . pg_last_error());
    }

    /**
     * @return array
     */
    public function listAll(){
        $this->sql = 'select * from gra order by nazwa';
        $result = pg_query($this->sql) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;

    }

    /**
     * @param $obj
     * @return resource
     */
    public function saveKategorie($obj){
        $res = pg_query_params("insert into kategoria (nazwa) values ($1);", Array($obj->nazwa));
        return $res;
    }


    /**
     * @param $obj
     * @return resource
     */
    public function saveSimple($obj){
        pg_query("begin");
        $res = pg_query_params("insert into gra (nazwa,data_wydania,opis,ocena,multiplayer) values ($1,$2,$3,$4,$5);", Array($obj->nazwa,$obj->data_wydania,$obj->opis,$obj->ocena,$obj->multiplayer));
        if($res) {
 	pg_query("commit");
            return $res;
        }else{
            pg_query("rollback;");
        }
    }

    /**
     * @param $obj
     * @return resource|string
     */
    public function saveAdvanced($obj){
        pg_query("begin");
        $res = pg_query_params("select insert_advanced($1,$2,$3,$4,$5,$6,$7,$8,$9,$10);", Array($obj->nazwa,$obj->data_wydania,$obj->opis,$obj->ocena,$obj->multiplayer,$obj->producent,$obj->wydawca,$obj->wydawca_pl,$obj->kategorie,$obj->platformy));
        if($res) {
	        //echo "dziala";
	        pg_query("commit");
            return $res;
        }else{
            pg_query("rollback");
            return pg_last_error();
        }
    }

    /**
     * @param $obj
     * @return resource|string
     */
    public function savePlatformy($obj){
        pg_query("begin");
        $res = pg_query_params("insert into platforma (nazwa,producent) VALUES ($1,$2);", Array($obj->nazwa,$obj->producent));
        if($res) {
	        //echo "dziala";
	        pg_query("commit");
            return $res;
        }else{
            //echo "niedziala";
            pg_query("rollback");
            return pg_last_error();
        }

    }
//USUWANIE!

    /**
     * @param $obj
     * @return resource
     */
    public function deleteGry($obj){
        $result = pg_query_params('select delete_gra($1);',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        return $result;
    }

    /**
     * @param $obj
     * @return resource
     */
    public function deleteKat($obj){
        $result = pg_query_params('DELETE FROM kategoria WHERE nazwa=$1;',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        return $result;
    }

    /**
     * @param $obj
     * @return resource
     */
    public function deletePlat($obj){
        $result = pg_query_params('DELETE FROM platforma WHERE nazwa = $1;',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        return $result;
    }

//////////////////////////////
    /**
     * @param $obj
     * @return array
     */
    public function search($obj){

        $result = pg_query_params('select szukanie.*, gra.idgra from szukanie join gra on gra.nazwa = szukanie.nazwa where szukanie.nazwa = $1;',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }

    /**
     * @param $obj
     * @return array
     */
    public function searchKategorie($obj){
        $result = pg_query_params('select nazwa_gry,ocena from szukanie_kategorii where kategoria like $1;',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }

    /**
     * @param $obj
     * @return array
     */
    public function searchPlatformy($obj){
        $result = pg_query_params('SELECT DISTINCT nazwa,ocena FROM wszystko WHERE platforma IS NOT NULL AND platforma LIKE $1 ORDER BY nazwa;',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }

    /**
     * @param $obj
     * @return array
     */
    public function searchOceny($obj){
        $result = pg_query_params('select DISTINCT nazwa,ocena,opis,multiplayer from wszystko where ocena > $1 ORDER BY ocena;',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }

    /**
     * @param $obj
     * @param $id
     * @return resource|string
     */
    public function ocena_change($obj, $id){
        pg_query("begin");
        $res = pg_query_params("select ocena_change($1,$2);", Array($id,$obj->ocena));
        if($res) {
            //echo "dziala";
            pg_query("commit");
            return $res;
        }else{
            //echo "niedziala";
            pg_query("rollback");
            return pg_last_error();
        }
    }

    /**
     * @param $obj
     * @return resource
     */
    public function saveRec($obj){

        $res = pg_query_params("insert into aaa (idtable_01,name) values ($1,$2);", Array($obj->idtable_01,$obj->name));
        return $res;
    }

    /**
     * @return array
     */
    public function getStatystyki(){
        $this->sql = "select * from statystyka;";
        $result = pg_query($this->sql) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }

    /**
     * @return array
     */
    public function getKategorie(){
        $this->sql = 'select * from kategoria ORDER BY NAZWA';
        $result = pg_query($this->sql) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }

    /**
     * @return array
     */
    public function getPlatformy(){
        $this->sql = 'select * from platforma ORDER BY NAZWA';
        $result = pg_query($this->sql) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }
}

