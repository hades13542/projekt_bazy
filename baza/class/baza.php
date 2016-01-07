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

    function saveKategorie(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa)){
            $response = $this->model->saveKategorie($obj);
        }
        return ($response ? "Dodano rekord" : "ERROR");
    }

    function saveSimple(){
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->nazwa) and isset($obj->data_wydania) and isset($obj->opis) and isset($obj->ocena) and isset($obj->multiplayer)){
            $response = $this->model->saveSimple($obj);
        }
        return ($response ? "Dodano rekord" : "ERROR");
    }

    function saveRec() {
        $data = $_POST['data'];
        $obj = json_decode($data);
        if(isset($obj->idtable_01) and isset($obj->name) ){
            $response = $this->model->saveRec($obj);
        }
        return ($response ? "Dodano rekord" : "ERROR!");
    }
}