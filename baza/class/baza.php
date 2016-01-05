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
        $this->layout->header = 'Not implemented (yet)';
        return $this->layout;
    }
}