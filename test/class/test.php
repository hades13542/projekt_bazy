<?php

class test extends controller {

    protected $layout ;

    /**
     * test constructor.
     */
    function __construct() {
        parent::__construct() ;
        $this->layout = new view('main') ;
        $this->layout->css = $this->css ;
        $this->layout->menu = $this->menu ;
        $this->layout->title = "Encyklopedia Gier Komputerowych";
        $this->layout->content = 'Jakikolwiek kontant';//"<a href='database.php'>Odczyt z bazy danych</a><br><a href='zapis.php'>Zapis do bazy danych</a>";
    }

    /**
     * @return view
     */
    function index() {
        return $this->layout ;
    }
}
