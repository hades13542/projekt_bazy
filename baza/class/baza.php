<?php

/**
 * Created by PhpStorm.
 * User: atar1x
 * Date: 05.01.16
 * Time: 00:41
 */

class baza extends controller
{
    protected $layout ;
    protected $model ;
    //public $id;
    function __construct()
    {
        parent::__construct();
        $this->layout = new view('main');
        $this->model = new database();
        $this->layout->css = $this->css;
        $this->layout->menu = $this->menu;
        $this->layout->title  = 'Encyklopedia Gier Komputerowych' ;
    }

    function listAll() {
        $this->layout->header = 'Lista wszystkich rekordow' ;
        $this->view = new view('listall') ;
        $this->view->data = $this->model->listAll() ;
        $this->layout->content = $this->view ;
        return $this->layout ;
    }

    function search(){
        $this->layout->header = 'Wyszukaj rekord który znajduje się w bazie (brak odpowiedzi oznacza nie istniejący rekord/błędne zapytanie)' ;
        $this->view = new view('search') ;
        $this->layout->content = $this->view;
        return $this->layout ;
    }

    function searchKat(){
        $this->layout->header = 'Wyszukaj gry z danej kategorii' ;
        $this->view = new view('searchKat') ;
        $this->layout->content = $this->view;
        return $this->layout ;
    }

    function insertRec(){
        $this->layout->header = 'Wprowadzanie do bazy';
        $this->view = new view('insert');
        //$this->view = new view('form');
        $this->layout->content = $this->view;
        return $this->layout;
    }

    function insertSimple(){
        $this->layout->header = 'Podaj podstawowe dane o grze i swoją ocenę';
        $this->view = new view('simpleForm');
        //$this->view = new view('form');
        $this->layout->content = $this->view;
        return $this->layout;
    }

    function insertKategorie(){
        $this->layout->header = 'Dodaj kategorię której nie ma w bazie';
        $this->view = new view('kategorieForm');
        $this->layout->content = $this->view;
        return $this->layout;
    }

    function insertAdvanced(){
        $this->layout->header = 'Dodaj informację o grze do bazy';
        $this->view = new view('advancedForm');
        $this->view->kat = $this->model->getKategorie();
        $this->view->platformy = $this->model->getPlatformy();
        $this->layout->content = $this->view;
        return $this->layout;
    }

    function insertPlatformy(){
        $this->layout->header = 'Dodaj nową platformę do bazy';
        $this->view = new view('platformyForm');
        $this->layout->content = $this->view;
        return $this->layout;
    }
    //obsluga po kliknieciu

    function saveKategorie(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa)){
            $response = $this->model->saveKategorie($obj);
        }
        return ($response ? "Dodano rekord" : "Podany rekord już istnieje lub zerwano połączenie z bazą. Spróbuj ponownie.");
    }

    function ocena_change(){
	if (isset($_COOKIE['ID'])) {
  	$id = unserialize($_COOKIE['ID']);
	} else {
        $id = 0;
       }
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->ocena)){
            $response = $this->model->ocena_change($obj,$id);
        }
        return ($response ? "Dodano ocenę" : "Ocenianie nie powiodło się");
    }

    function saveSimple(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa) and isset($obj->data_wydania) and isset($obj->opis) and isset($obj->ocena) and isset($obj->multiplayer)){
            $response = $this->model->saveSimple($obj);
        }
        return ($response ? "Dodano rekord" : "Podano błędne wartości lub zerwano połączenie z bazą. Spróbuj ponownie.");
    }

    function saveAdvanced(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa) and isset($obj->data_wydania) and isset($obj->opis) and isset($obj->ocena) and isset($obj->multiplayer)){
            $response = $this->model->saveAdvanced($obj);
        }
        return ($response) ? "Dodano rekord" : "Podano błędne wartości lub zerwano połączenie z bazą. Spróbuj ponownie.";
    }

    function savePlatformy(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa) and isset($obj->producent)){
            $response = $this->model->savePlatformy($obj);
        }
        return ($response) ? "Dodano rekord" : "Podano błędne wartości lub zerwano połączenie z bazą. Spróbuj ponownie.";
    }

    function saveRec() {
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->idtable_01) and isset($obj->name) ){
            $response = $this->model->saveRec($obj);
        }
        return ($response ? "Dodano rekord" : "ERROR!");
    }

    function searchKategorie(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa)){
            $response = $this->model->searchKategorie($obj);
        }
        $string = '<table><tr><td>Nazwa Gry</td><td>Ocena</td>';
        foreach($response as $row){
            $string = $string . '<tr><td>'.$row['nazwa_gry'].'</td><td>'.$row['ocena'].'</td></tr>';
        }
	$string = $string . '</table>';
        return $string;
    }

    function searchFunc(){
        $flag =0;
        $string = '<h3>';
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa)){
            $response = $this->model->search($obj);
        }

        //$test = json_encode($response);
        foreach ($response as $row) {
	$nazwa = $row['nazwa'];
	$Content = str_replace("{","",$row['data_wydania']);
	$data = str_replace("}","",$Content);
	$Content = str_replace("{","",$row['ocena']);
	$ocena = str_replace("}","",$Content);
	$Content = str_replace("{","",$row['opis']);
	$opis = str_replace("}","",$Content);
	$Content = str_replace("{","",$row['kategoria']);
	$kategoria = str_replace("}","",$Content);
	$Content = str_replace("{","",$row['wydawca']);
	$wydawca = str_replace("}","",$Content);
	$Content = str_replace("{","",$row['producent']);
	$producent = str_replace("}","",$Content);
	$Content = str_replace("{","",$row['wydawca_pl']);
	$wydawca_pl = str_replace("}","",$Content);
	$Content = str_replace("{","",$row['platformy']);
	$platformy = str_replace("}","",$Content);
	$Content = str_replace("{","",$row['ilosc_ocen']);
	$ilosc_ocen = str_replace("}","",$Content);
            if ($row['multiplayer'] == 'f'){
                $row['multiplayer'] = "NIE";
            }else{
                $row['multiplayer'] = "TAK";
            }
            $string = $string . ''.$row['nazwa'].'</h3>Data wydania:&nbsp'.$data.'&nbsp&nbsp&nbsp&nbsp<br>Producent:&nbsp'.$producent.'Wydawca:&nbsp'.$wydawca.'&nbsp&nbsp&nbsp&nbsp Wydawca w Polsce&nbsp'.$wydawca_pl.'<br>Ocena:&nbsp'.$ocena.'&nbsp&nbsp&nbsp&nbspIlosc ocen: '.$ilosc_ocen.'<br>Multiplayer:&nbsp&nbsp'.$row['multiplayer'].'<br>Kategorie: '.$kategoria.'<br>Platformy:'.$platformy.'<br><br>'.$opis.'';

        }
        //TODO: kurwa jak to ogarniac
	$id = $row['idgra'];
	setcookie('ID', serialize($id), 0);
        return $string . '<br>';//$row['nazwa'];//$string;//$response->nazwa;//print_r($response);
    }
}
