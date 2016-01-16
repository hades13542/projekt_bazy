<?php


/**
 * Class view zajmujaca sie obsługą widoków
 */
class view
{
    /**
     * @var string przechowywujaca pliki z widokami
     */
    protected $_file;
    /**
     * @var array przechowujaca wszystkie widoki
     */
    protected $_data = array();

    /**
     * view constructor służy do incjalizowania nowego widoku
     * @param $template
     * @throws Exception
     */
    public function __construct($template)
    {
        $file = 'template/'.$template.'.tpl';
        if (file_exists($file)){$this->_file = $file;}
        else {throw new Exception("Template".$file."nie istnieje.");}
    }

    /**
     * sluzy do dodawaniu nowych widokow
     * @param $key
     * @param $value
     */
    public function __set($key, $value)
    {
        $this->_data[$key]=$value;
    }

    /**
     * sluzy do pobierania nowych widokow
     * @param $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->_data[$key];
    }

    /**
     * sluzy do wyswietlenia nowych widokow
     * @return string
     */
    public function __toString()
    {
        extract($this->_data);
        ob_start();
        include($this->_file);
        $output = ob_get_contents();
        ob_end_clean();
        return $output;
    }
}