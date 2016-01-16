<?php


/**
 * Class controller zajmuje sie obsługą wszystkich działań w bazie
 */
abstract class controller {

    /**
     * @var string przechowuje link do pliku .css
     */
    protected $css ;
    /**
     * @var string przechowuje link do menu po lewej stronie
     */
    protected $menu ;

    /**
     * controller constructor.
     */
    function __construct() {
        $this->css  = '<link rel="stylesheet" href="baza.css" type="text/css" media="screen" >' ;
        $this->menu = file_get_contents ('template/menu.tpl') ;
    }


    /**
     *  Funkcja generujaca bląd 404
     */
    static function http404() {
        header('HTTP/1.1 404 Not Found') ;
        print '<!doctype html><html><head><title>404 Not Found</title></head><body><p>Invalid URL</p></body></html>' ;
        exit ;
    }

    /**
     * funkcja wywołująca błąd 404
     * @param $name
     * @param $arguments
     */
    function __call($name, $arguments)
    {
        self::http404();
    }
}
