<?php


/**
 * Class database zarzadzająca wszelakimi operacjami w bazie
 */
class database
{
    /**
     * @var string przechowywujące dane do połączenia sie z bazą danych
     */
    static $conn_string = 'host=pellefant-01.db.elephantsql.com dbname=xmvwbdee user=xmvwbdee password=ge3juV_jk0VgFE2VrDgD-ZOi9D2J5hHp';
    //static $conn_string = 'host=pellefant-01.db.elephantsql.com dbname=kgkxlucn user=kgkxlucn password=-mz6ZfLVObAUKIW0rngT0MJSLKJVBgY_';
    /**
     * @var resource zmienna przechowywujaca połączenie z bazą danych
     */
    protected static $dbconn;
    /**
     * @var przechowywująca zapytania sql.
     */
    private $sql;

    /**
     * database constructor Łączy się z bazą danych lub zwraca błąd.
     */
    function __construct()
    {
        self::$dbconn = pg_connect(self::$conn_string) or die('Nie mozna polaczyc z baza' . pg_last_error());
    }

    /**
     * Funkcja wyświetla zawartość calej tablicy gra posortowaną wg nazw.
     * @return array
     */
    public function listAll(){
        $this->sql = 'select * from gra order by nazwa';
        $result = pg_query($this->sql) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;

    }

    /**
     * Funkcja służąca do dodawania kategorii
     * @param $obj obiekt zawierający nazwę nowej kategorii
     * @return resource zwraca true, jeśli się powiodło.
     */
    public function saveKategorie($obj){
        $res = pg_query_params("insert into kategoria (nazwa) values ($1);", Array($obj->nazwa));
        return $res;
    }


    /**
     * Funkcja zapisujaca dane do tabeli gra. Dodatkowo obsługuje transakcję.
     * @param $obj obiekt przechowywujace dane zebrane z formularza
     * @return resource|string zwraca true, jeśli się powiodło, jeśli false zwraca error.
     */
    public function saveSimple($obj){
        pg_query("begin");
        $res = pg_query_params("insert into gra (nazwa,data_wydania,opis,ocena,multiplayer) values ($1,$2,$3,$4,$5);", Array($obj->nazwa,$obj->data_wydania,$obj->opis,$obj->ocena,$obj->multiplayer));
        if($res) {
 	pg_query("commit");
            return $res;
        }else{
            pg_query("rollback");
            return pg_last_error();
        }
    }

    /**
     * Funkcja zapisujaca dane do tabeli gra, podłącza kategorie, platformy, oraz uzupełnia informację o twórach/wydawcach. Dodatkowo obsługuje transakcję.
     * @param $obj przechowywujace dane zebrane z formularza
     * @return resource|string zwraca true, jeśli się powiodło, jeśli false zwraca error.
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
     * Funkcja dodająca nową platformę. Dodatkowo obsługuje transakcje.
     * @param $obj przechowuje dane z formularza
     * @return resource|string zwraca true, jeśli się powiodło, jeśli false zwraca error.
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

    /**
     * Funkcja obsługująca usuwanie z tabeli gra.
     * @param $obj przyjmuje zawartość formularza -> nazwę gry do usunięcia.
     * @return resource zwraca true, jeśli się powiodło.
     */
    public function deleteGry($obj){
        $result = pg_query_params('select delete_gra($1);',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        return $result;
    }

    /**
     * Funkcja obsługująca usuwanie z tabeli kategoria.
     * @param $obj  przyjmuje zawartość formularza -> nazwę kategorii do usunięcia.
     * @return resource zwraca true, jeśli się powiodło.
     */
    public function deleteKat($obj){
        $result = pg_query_params('DELETE FROM kategoria WHERE nazwa=$1;',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        return $result;
    }

    /**
     * Funkcja obsługująca usuwanie z tabeli platforma.
     * @param $obj  przyjmuje zawartość formularza -> nazwę platformy do usunięcia.
     * @return resource zwraca true, jeśli się powiodło.
     */
    public function deletePlat($obj){
        $result = pg_query_params('DELETE FROM platforma WHERE nazwa = $1;',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        return $result;
    }

    /**
     * Funkcja służąca do wyszukiwania gry w widoku "szukanie"
     * @param $obj obiekt przechowywujacy nazwę szukanej gry
     * @return array tablica wszystkich danych o grze
     */
    public function search($obj){

        $result = pg_query_params('select szukanie.*, gra.idgra from szukanie join gra on gra.nazwa = szukanie.nazwa where szukanie.nazwa = $1;',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }

    /**
     * Funkcja służąca do wyszukiwania wg kategorii
     * @param $obj obiekt przechowywujacy nazwę szukanej kategorii
     * @return array tablica wszystkich gier danej kategorii wraz z ocenami
     */
    public function searchKategorie($obj){
        $result = pg_query_params('select nazwa_gry,ocena from szukanie_kategorii where kategoria like $1;',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }

    /**
     * Funkcja służąca do wyszukiwania wg platformy
     * @param $obj obiekt przechowywujacy nazwę szukanej platformy
     * @return array tablica wszystkich gier danej kategorii wraz z ocenami
     */
    public function searchPlatformy($obj){
        $result = pg_query_params('SELECT DISTINCT nazwa,ocena FROM wszystko WHERE platforma IS NOT NULL AND platforma LIKE $1 ORDER BY nazwa;',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }

    /**
     * Funkcja służąca do wyszukiwania gier o ocenie wiekszej niż zadana
     * @param $obj obiekt przechowywujacy ocenę
     * @return array tablica wszystkich gier o ocenie większej niż zadana
     */
    public function searchOceny($obj){
        $result = pg_query_params('select DISTINCT nazwa,ocena,opis,multiplayer from wszystko where ocena > $1 ORDER BY ocena;',Array($obj->nazwa)) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }

    /**
     * Funkcja mająca za za zadanie dodanie nowej oceny dla danej gry.
     * @param $obj obiekt przechowywujący nową ocenę
     * @param $id id gry która aktualnie jest wyszukana
     * @return resource|string zwraca true, jeśli się powiodło, jeśli false zwraca error.
     */
    public function ocena_change($obj, $id){
        pg_query("begin");
        $res = pg_query_params("select ocena_change($1,$2);", Array($id,$obj->ocena));
        if($res) {
            pg_query("commit");
            return $res;
        }else{
            pg_query("rollback");
            return pg_last_error();
        }
    }

    /**
     * Funkcja testowa!
     * @param $obj obiekt z testowymi danymi
     * @return resource
     */
    public function saveRec($obj){

        $res = pg_query_params("insert into aaa (idtable_01,name) values ($1,$2);", Array($obj->idtable_01,$obj->name));
        return $res;
    }

    /**
     * Funkcja pobierająca statystyki o bazie danych
     * @return array tablica z wszystkimi statystykami
     */
    public function getStatystyki(){
        $this->sql = "select * from statystyka;";
        $result = pg_query($this->sql) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }

    /**
     * Funkcja pobierająca wszystkie kategorie, używana przy wpisywaniu zaawansowanym
     * @return array zwraca tablicę z wszystkimi kategoriami.
     */
    public function getKategorie(){
        $this->sql = 'select * from kategoria ORDER BY NAZWA';
        $result = pg_query($this->sql) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }

    /**
     * Funkcja pobierająca wszystkie platformy, używana przy wpisywaniu zaawansowanym
     * @return array zwraca tablicę z wszystkimi platformami.
     */
    public function getPlatformy(){
        $this->sql = 'select * from platforma ORDER BY NAZWA';
        $result = pg_query($this->sql) or die('Nieprawidlowe zapytanie '. pg_last_error());
        $line = pg_fetch_all($result);
        return $line;
    }
}

