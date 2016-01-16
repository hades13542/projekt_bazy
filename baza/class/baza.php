<?php

/**
 * Created by PhpStorm.
 * User: atar1x
 * Date: 05.01.16
 * Time: 00:41
 */

class baza extends controller
{
    /**
     * @var view
     */
    protected $layout ;
    /**
     * @var database
     */
    protected $model ;
    //public $id;
    /**
     * baza constructor.
     */
    function __construct()
    {
        parent::__construct();
        $this->layout = new view('main');
        $this->model = new database();
        $this->layout->css = $this->css;
        $this->layout->menu = $this->menu;
        $this->layout->title  = 'Encyklopedia Gier Komputerowych' ;
    }

    /**
     * @return view
     */
    function listAll() {
        $this->layout->header = 'Lista wszystkich rekordow' ;
        $this->view = new view('listall') ;
        $this->view->data = $this->model->listAll() ;
        $this->layout->content = $this->view ;
        return $this->layout ;
    }

    function statystyka(){
        $string = "Witaj w encyklopedii gier komputerowych, wybierz interesującą Cię funkcję z menu po lewej.<br><br><br><br>Obecnie w naszej bazie znajduje się: ";
        $response = $this->model->getStatystyki();
        foreach($response as $row){
            $string = $string .$row['ilosc_gier'].' gier podzielonych na '. $row['ilosc_kategorii'] .' kategorii oraz '.$row['ilosc_platform']. ' platform<br>Wystawiono ' .$row['ilosc_ocen'].' oceny co daje średnio '.round($row['srednia'],2).' na grę!<br>';
        }

        return $string ;
    }
    /**
     * @return view
     */
    function search(){
        $this->layout->header = 'Wyszukaj rekord który znajduje się w bazie (brak odpowiedzi oznacza nie istniejący rekord/błędne zapytanie)' ;
        $this->view = new view('search') ;
        $this->layout->content = $this->view;
        return $this->layout ;
    }

    /**
     * @return view
     */
    function searchKat(){
        $this->layout->header = 'Wyszukaj gry z danej kategorii' ;
        $this->view = new view('searchKat') ;
        $this->layout->content = $this->view;
        return $this->layout ;
    }

    /**
     * @return view
     */
    function searchPlat(){
        $this->layout->header = 'Wyszukaj gry na daną platformę' ;
        $this->view = new view('searchPlat') ;
        $this->layout->content = $this->view;
        return $this->layout ;
    }

    /**
     * @return view
     */
    function searchOcena(){
        $this->layout->header = 'Wyszukaj gry o ocenie wyższej niż podana' ;
        $this->view = new view('searchOcena') ;
        $this->layout->content = $this->view;
        return $this->layout ;
    }

    /**
     * @return view
     */
    function insertRec(){
        $this->layout->header = 'Wprowadzanie do bazy';
        $this->view = new view('insert');
        //$this->view = new view('form');
        $this->layout->content = $this->view;
        return $this->layout;
    }

    /**
     * @return view
     */
    function insertSimple(){
        $this->layout->header = 'Podaj podstawowe dane o grze i swoją ocenę';
        $this->view = new view('simpleForm');
        //$this->view = new view('form');
        $this->layout->content = $this->view;
        return $this->layout;
    }

    /**
     * @return view
     */
    function insertKategorie(){
        $this->layout->header = 'Dodaj kategorię której nie ma w bazie';
        $this->view = new view('kategorieForm');
        $this->layout->content = $this->view;
        return $this->layout;
    }

    /**
     * @return view
     */
    function insertAdvanced(){
        $this->layout->header = 'Dodaj informację o grze do bazy';
        $this->view = new view('advancedForm');
        $this->view->kat = $this->model->getKategorie();
        $this->view->platformy = $this->model->getPlatformy();
        $this->layout->content = $this->view;
        return $this->layout;
    }

    /**
     * @return view
     */
    function insertPlatformy(){
        $this->layout->header = 'Dodaj nową platformę do bazy';
        $this->view = new view('platformyForm');
        $this->layout->content = $this->view;
        return $this->layout;
    }
    //PANEL ADMINA

    /**
     * @return view
     */
    function admin(){
        $this->layout->header = 'Panel admina';
        $this->view = new view('admin');
        $this->layout->content = $this->view;
        return $this->layout;
    }
//usuwanie

    /**
     * @return view
     */
    function deleteGra(){
        $this->layout->header = 'Usuwanie gry po tytule';
        $this->view = new view('deleteGra');
        $this->layout->content = $this->view;
        return $this->layout;
    }

    /**
     * @return view
     */
    function deleteKategoria(){
        $this->layout->header = 'Usuwanie ketegorii';
        $this->view = new view('deleteKategoria');
        $this->layout->content = $this->view;
        return $this->layout;
    }

    /**
     * @return view
     */
    function deletePlatforma(){
        $this->layout->header = 'Usuwanie platformy';
        $this->view = new view('deletePlatforma');
        $this->layout->content = $this->view;
        return $this->layout;
    }

    /**
     * @return string
     */
    function deleteGry(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa)){
            $response = $this->model->deleteGry($obj);
        }
        return ($response ?  "Usunięto pomyślnie" : "Podany rekord nie istnieje lub zerwano połączenie z bazą.");
    }

    /**
     * @return string
     */
    function deleteKat(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa)){
            $response = $this->model->deleteKat($obj);
        }
        return ($response ?  "Usunięto pomyślnie" : "Podany rekord nie istnieje lub zerwano połączenie z bazą.");
    }

    /**
     * @return string
     */
    function deletePlat(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa)){
            $response = $this->model->deletePlat($obj);
        }
        return ($response ? "Usunięto pomyślnie" : "Podany rekord nie istnieje lub zerwano połączenie z bazą.");
    }

    //obsluga po kliknieciu


    /**
     * @return string
     */
    function saveKategorie(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa)){
            $response = $this->model->saveKategorie($obj);
        }
        return ($response ? "Dodano rekord" : "Podany rekord już istnieje lub zerwano połączenie z bazą. Spróbuj ponownie.");
    }

    /**
     * @return string
     */
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

    /**
     * @return string
     */
    function saveSimple(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa) and isset($obj->data_wydania) and isset($obj->opis) and isset($obj->ocena) and isset($obj->multiplayer)){
            $response = $this->model->saveSimple($obj);
        }
        return ($response ? "Dodano rekord" : "Podano błędne wartości lub zerwano połączenie z bazą. Spróbuj ponownie.");
    }

    /**
     * @return string
     */
    function saveAdvanced(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa) and isset($obj->data_wydania) and isset($obj->opis) and isset($obj->ocena) and isset($obj->multiplayer)){
            $response = $this->model->saveAdvanced($obj);
        }
        return ($response) ? "Dodano rekord" : "Podano błędne wartości lub zerwano połączenie z bazą. Spróbuj ponownie.";
    }

    /**
     * @return string
     */
    function savePlatformy(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa) and isset($obj->producent)){
            $response = $this->model->savePlatformy($obj);
        }
        return ($response) ? "Dodano rekord" : "Podano błędne wartości lub zerwano połączenie z bazą. Spróbuj ponownie.";
    }

    /**
     * @return string
     */
    function saveRec() {
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->idtable_01) and isset($obj->name) ){
            $response = $this->model->saveRec($obj);
        }
        return ($response ? "Dodano rekord" : "ERROR!");
    }

    /**
     * @return string
     */
    function searchOceny(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa)){
            $response = $this->model->searchOceny($obj);
        }
        $string = '<table border="1"><tr><td>Nazwa Gry</td><td>Ocena</td><td>Opis Gry</td><td>Multiplayer</td>';
        foreach($response as $row){
            if ($row['multiplayer'] == f){
                $row['multiplayer'] = "NIE";
            }else{
                $row['multiplayer'] = "TAK";
            }
            $string = $string . '<tr><td>'.$row['nazwa'].'</td><td>'.round($row['ocena'],2).'</td><td>'.$row['opis'].'</td><td>'.$row['multiplayer'].'</td></tr>';
        }
        $string = $string . '</table>';
        return $string;
    }

    /**
     * @return string
     */
    function searchKategorie(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa)){
            $response = $this->model->searchKategorie($obj);
        }
        $string = '<table border="1"><tr><td>Nazwa Gry</td><td>Ocena</td>';
        foreach($response as $row){
            $string = $string . '<tr><td>'.$row['nazwa_gry'].'</td><td>'.round($row['ocena'],2).'</td></tr>';
        }
	$string = $string . '</table>';
        return $string;
    }

    /**
     * @return string
     */
    function searchPlatformy(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa)){
            $response = $this->model->searchPlatformy($obj);
        }
        $string = '<table border="1"><tr><td>Nazwa Gry</td><td>Ocena</td>';
        foreach($response as $row){
            $string = $string . '<tr><td>'.$row['nazwa'].'</td><td>'.round($row['ocena'],2).'</td></tr>';
        }
        $string = $string . '</table>';
        return $string;
    }


    /**
     * @return string
     */
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
            $string = $string . ''.$row['nazwa'].'</h3>Data wydania:&nbsp'.$data.'&nbsp&nbsp&nbsp&nbsp<br>Producent:&nbsp'.$producent.'Wydawca:&nbsp'.$wydawca.'&nbsp&nbsp&nbsp&nbsp Wydawca w Polsce&nbsp'.$wydawca_pl.'<br>Ocena:&nbsp'.round($ocena,2).'&nbsp&nbsp&nbsp&nbspIlosc ocen: '.$ilosc_ocen.'<br>Multiplayer:&nbsp&nbsp'.$row['multiplayer'].'<br>Kategorie: '.$kategoria.'<br>Platformy:'.$platformy.'<br><br>'.$opis.'';

        }
	$id = $row['idgra'];
	setcookie('ID', serialize($id), 0);
        return $string . '<br>';//$row['nazwa'];//$string;//$response->nazwa;//print_r($response);
    }
}
