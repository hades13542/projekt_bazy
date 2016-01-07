<?php

/**
 * Created by PhpStorm.
 * User: atar1x
 * Date: 04.01.16
 * Time: 20:42
 */

class info extends controller {

    protected $layout ;
    protected $model ;

    function __construct() {
        parent::__construct() ;
        $this->layout = new view('main') ;
        $this->layout->css = $this->css ;
        $this->layout->menu = $this->menu ;
        $this->layout->title = "Encyklopedia Gier Komputerowych" ;
    }

    function index() {
        $this->layout->header  = 'Dziala index' ;
        $this->layout->content = 'Index kontent';//'<a href=\'database.php\'>Odczyt z bazy danych</a><br><a href=\'zapis.php\'>Zapis do bazy danych</a>' ;
        return $this->layout ;
    }

    function help() {
        $this->model = new model();
        $this->layout->header  = 'Simple MVC' ;
        $this->view = new view('table') ;
        $this->view->data = $this->model->getTable() ;
        $this->layout->content = $this->view ;
        return $this->layout ;
    }


    function test(){
        $this->model = new model();
        $this->layout->header = "TESt";
        return $this->layout;
    }

}

